<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Store;
use App\Models\Company;
use App\Models\StoremapCategory;
use App\Models\GroupCode;
use App\Models\ItemImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; //ファイルアクセス
use Gate;
use Illuminate\Support\Collection;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // 検索からキーワード取得
        $keyword = $request->input('keyword');
        if (isset($keyword)) {
            $my_items = Item::where('company_id', $user->company_id)->pluck('product_code');
            // カンパニーIDでセグメントしてから、orWhereのいずれかにあてはまったものを抽出
            // 自分が登録している商品は除外
            $items = Item::where('global_flag', 1)->where('company_id', '!=', $user->company_id)
                ->whereNotIn('barcode', $my_items)
                ->where(function ($query) use ($keyword) {
                    $query->orWhere('product_code', 'like', '%' . $keyword . '%')
                        ->orWhere('product_name', 'like', '%' . $keyword . '%')
                        ->orWhere('barcode', 'like', '%' . $keyword . '%');
                })->paginate(30);
            // $items = Item::where('global_flag', 1)->where('company_id', '!=', $user->company_id)->whereNotIn('product_code', $my_items)->where('product_name', 'like', '%' . $keyword . '%')->get();
            // dd($my_items,$items);
            return view('catalog.index', [
                'items' => $items,
                'keyword' => $keyword,
                // 'count' => $count,
            ]);
        } else {
            // $my_items = Item::where('company_id' , $user->company_id)->pluck('barcode');
            // $items = Item::where('global_flag', 1)->where('company_id', '!=', $user->company_id)->whereNotIn('barcode', $my_items)->paginate(30);
            // 何も入力ない場合は何も表示しない

            return view('catalog.index', [
                'keyword' => $keyword,
            ]);
        }
        // $count = Item::where('company_id', $user->company_id)->get()->count();
    }

    public function show($id)
    {
        $user = Auth::user();
        $item = Item::find($id);
        $base_company = Company::where('id', $item->company_id)->pluck('img_flag')->first();
        // dd($store);
        $result = StoremapCategory::ancestorsAndSelf($item->storemap_category_id);
        $smcate = $result->implode('smcategory_name', ' > ');
        $img_list = [];

        if ($item->item_img1) {
            $img_list[] = $item->item_img1;
        }
        if ($item->item_img2) {
            $img_list[] = $item->item_img2;
        }
        if ($item->item_img3) {
            $img_list[] = $item->item_img3;
        }
        if ($item->item_img4) {
            $img_list[] = $item->item_img4;
        }
        if ($item->item_img5) {
            $img_list[] = $item->item_img5;
        }
        if ($item->item_img6) {
            $img_list[] = $item->item_img6;
        }
        if ($item->item_img7) {
            $img_list[] = $item->item_img7;
        }
        if ($item->item_img8) {
            $img_list[] = $item->item_img8;
        }
        if ($item->item_img9) {
            $img_list[] = $item->item_img9;
        }
        if ($item->item_img10) {
            $img_list[] = $item->item_img10;
        }

        // 登録あるかチェック。ない場合はfalse ある場合はtrue。コピーor詳細ボタンのための設定
        $copy_id = Item::where('company_id', $user->company_id)->where('barcode', $item->barcode)->first();
        // dd($base_company);
        return view('catalog.show', compact('item', 'smcate', 'img_list', 'copy_id', 'base_company'));
    }

    public function copy(Request $request)
    {
        $user = Auth::user();

        // 自作関数productCountを呼び出し。上限チェック
        $resultItem = productCount($user);
        // dd($result);
        if(!$resultItem){
            // dd($result);
            return back()->with('warning', '登録出来る商品数の上限を超えています。');
        }

        // コピー元の商品情報を取得
        $base_item = Item::find($request->id);
        $base_company_id = $base_item->company_id;
        $base_company = Company::find($base_company_id);

        // 登録あるかチェック。ない場合はfalse ある場合はtrue
        $pcode = Item::where('company_id', $user->company_id)->where('product_code', $base_item->product_code)->exists();
        // 登録あるかチェック。ない場合はfalse ある場合はtrue
        $bcode = Item::where('company_id', $user->company_id)->where('barcode', $base_item->barcode)->exists();

        if ($pcode) {
            return back()->with('warning', '同じ商品コードの登録があります');
        }

        if ($bcode) {
            return back()->with('warning', '同じJANコードの登録があります');
        }

        // 商品情報をコピー
        $item = $base_item->replicate();

        // 必要な情報を上書き
        $item->company_id = $user->company_id;
        $item->display_flag = 1;
        $item->category_id = null;
        $item->global_flag = 0;

        if (isset($base_item->group_code_id)) {
            // 元データにグループコードがある場合
            // 元データのグループコードから、コピー先の会社ID内に同じグループ名があるか確認
            $gc = $base_item->group_code->group_code;
            $group = DB::table('group_codes')->where('company_id', $user->company_id)->where('group_code', $gc)->exists();

            if ($group) {
                // グループ名の登録がある場合
                $gid = GroupCode::where('company_id', $user->company_id)->where('group_code', $gc)->first();
                $item->group_code_id = $gid->id;
            } elseif (!$group && isset($gc)) {
                // グループ名の登録がなくて、グループ名が入力されている場合の処理
                $gcd = new GroupCode;
                $gcd->group_code = $gc;
                $gcd->company_id = $user->company_id;
                $gcd->save();
                // 保存したIDを取得
                $last_insert_id = $gcd->id;
                $item->group_code_id = $last_insert_id;
            }
        } else {
            //グループコード未記入の場合の処理
            $item->group_code_id = null;
        }

        // アロー演算子のプロパティ値に変数使う方法誰か教えて！
        // 使えたらfor文で書けるのに…

        if ($base_company->img_flag === 1) {
            // 画像利用が可の場合はコピー
            if ($base_item->item_img1) {
                $base_img = '/public/' . $base_item->company_id . '/items/' . $base_item->item_img1;
                $copy_img = '/public/' . $user->company_id . '/items/' . $base_item->item_img1;
                // 同じファイル名のファイルがあった場合は上書き
                if (Storage::exists($base_img)) {
                    // 元ファイルの存在チェック

                    $base_item_img1 = ItemImage::where('filename', $base_item->item_img1)->where('company_id', $base_item->company_id)->first();
                    if (!is_null($base_item_img1)) {
                        $copy_item_img1 = $base_item_img1->replicate();
                        // ItemImageを検索してコピー
                        $copy_item_img1->company_id = $user->company_id;
                        // カンパニーIDだけ更新。IDやタイムスタンプは自動更新
                        $copy_item_img1->save();

                        if (Storage::exists($copy_img)) {
                            // 元ファイルが存在する場合、コピー先ファイルの存在チェック
                            Storage::delete($copy_img);
                            // 存在すれば削除
                            Storage::copy($base_img, $copy_img);
                            // 削除後にコピー
                        } else {
                            // コピー先にファイルがなければ普通にコピー
                            Storage::copy($base_img, $copy_img);
                        }
                    }
                } else {
                    $item->item_img1 = null;
                    // 元ファイルない場合は、DBもnullで登録
                }
            }
            if ($base_item->item_img2) {
                $base_img = '/public/' . $base_item->company_id . '/items/' . $base_item->item_img2;
                $copy_img = '/public/' . $user->company_id . '/items/' . $base_item->item_img2;
                if (Storage::exists($base_img)) {

                    $base_item_img2 = ItemImage::where('filename', $base_item->item_img2)->where('company_id', $base_item->company_id)->first();
                    if (!is_null($base_item_img2)) {
                        $copy_item_img2 = $base_item_img2->replicate();
                        // ItemImageを検索してコピー
                        $copy_item_img2->company_id = $user->company_id;
                        // カンパニーIDだけ更新。IDやタイムスタンプは自動更新
                        $copy_item_img2->save();

                        if (Storage::exists($copy_img)) {
                            Storage::delete($copy_img);
                            Storage::copy($base_img, $copy_img);
                        } else {
                            // コピー先にファイルがなければ普通にコピー
                            Storage::copy($base_img, $copy_img);
                        }
                    }
                } else {
                    $item->item_img2 = null;
                }
            }
            if ($base_item->item_img3) {
                $base_img = '/public/' . $base_item->company_id . '/items/' . $base_item->item_img3;
                $copy_img = '/public/' . $user->company_id . '/items/' . $base_item->item_img3;
                if (Storage::exists($base_img)) {

                    $base_item_img3 = ItemImage::where('filename', $base_item->item_img3)->where('company_id', $base_item->company_id)->first();
                    if (!is_null($base_item_img3)) {
                        $copy_item_img3 = $base_item_img3->replicate();
                        // ItemImageを検索してコピー
                        $copy_item_img3->company_id = $user->company_id;
                        // カンパニーIDだけ更新。IDやタイムスタンプは自動更新
                        $copy_item_img3->save();

                        if (Storage::exists($copy_img)) {
                            Storage::delete($copy_img);
                            Storage::copy($base_img, $copy_img);
                        } else {
                            // コピー先にファイルがなければ普通にコピー
                            Storage::copy($base_img, $copy_img);
                        }
                    }
                } else {
                    $item->item_img3 = null;
                }
            }
            if ($base_item->item_img4) {
                $base_img = '/public/' . $base_item->company_id . '/items/' . $base_item->item_img4;
                $copy_img = '/public/' . $user->company_id . '/items/' . $base_item->item_img4;
                if (Storage::exists($base_img)) {

                    $base_item_img4 = ItemImage::where('filename', $base_item->item_img4)->where('company_id', $base_item->company_id)->first();
                    if (!is_null($base_item_img4)) {
                        $copy_item_img4 = $base_item_img4->replicate();
                        // ItemImageを検索してコピー
                        $copy_item_img4->company_id = $user->company_id;
                        // カンパニーIDだけ更新。IDやタイムスタンプは自動更新
                        $copy_item_img4->save();

                        if (Storage::exists($copy_img)) {
                            Storage::delete($copy_img);
                            Storage::copy($base_img, $copy_img);
                        } else {
                            // コピー先にファイルがなければ普通にコピー
                            Storage::copy($base_img, $copy_img);
                        }
                    }
                } else {
                    $item->item_img4 = null;
                }
            }
            if ($base_item->item_img5) {
                $base_img = '/public/' . $base_item->company_id . '/items/' . $base_item->item_img5;
                $copy_img = '/public/' . $user->company_id . '/items/' . $base_item->item_img5;
                if (Storage::exists($base_img)) {

                    $base_item_img5 = ItemImage::where('filename', $base_item->item_img5)->where('company_id', $base_item->company_id)->first();
                    if (!is_null($base_item_img5)) {
                        $copy_item_img5 = $base_item_img5->replicate();
                        // ItemImageを検索してコピー
                        $copy_item_img5->company_id = $user->company_id;
                        // カンパニーIDだけ更新。IDやタイムスタンプは自動更新
                        $copy_item_img5->save();

                        if (Storage::exists($copy_img)) {
                            Storage::delete($copy_img);
                            Storage::copy($base_img, $copy_img);
                        } else {
                            // コピー先にファイルがなければ普通にコピー
                            Storage::copy($base_img, $copy_img);
                        }
                    }
                } else {
                    $item->item_img5 = null;
                }
            }
            if ($base_item->item_img6) {
                $base_img = '/public/' . $base_item->company_id . '/items/' . $base_item->item_img6;
                $copy_img = '/public/' . $user->company_id . '/items/' . $base_item->item_img6;
                if (Storage::exists($base_img)) {

                    $base_item_img6 = ItemImage::where('filename', $base_item->item_img6)->where('company_id', $base_item->company_id)->first();
                    if (!is_null($base_item_img6)) {
                        $copy_item_img6 = $base_item_img6->replicate();
                        // ItemImageを検索してコピー
                        $copy_item_img6->company_id = $user->company_id;
                        // カンパニーIDだけ更新。IDやタイムスタンプは自動更新
                        $copy_item_img6->save();

                        if (Storage::exists($copy_img)) {
                            Storage::delete($copy_img);
                            Storage::copy($base_img, $copy_img);
                        } else {
                            // コピー先にファイルがなければ普通にコピー
                            Storage::copy($base_img, $copy_img);
                        }
                    }
                } else {
                    $item->item_img6 = null;
                }
            }
            if ($base_item->item_img7) {
                $base_img = '/public/' . $base_item->company_id . '/items/' . $base_item->item_img7;
                $copy_img = '/public/' . $user->company_id . '/items/' . $base_item->item_img7;
                if (Storage::exists($base_img)) {

                    $base_item_img7 = ItemImage::where('filename', $base_item->item_img7)->where('company_id', $base_item->company_id)->first();
                    if (!is_null($base_item_img7)) {
                        $copy_item_img7 = $base_item_img7->replicate();
                        // ItemImageを検索してコピー
                        $copy_item_img7->company_id = $user->company_id;
                        // カンパニーIDだけ更新。IDやタイムスタンプは自動更新
                        $copy_item_img7->save();

                        if (Storage::exists($copy_img)) {
                            Storage::delete($copy_img);
                            Storage::copy($base_img, $copy_img);
                        } else {
                            // コピー先にファイルがなければ普通にコピー
                            Storage::copy($base_img, $copy_img);
                        }
                    }
                } else {
                    $item->item_img7 = null;
                }
            }
            if ($base_item->item_img8) {
                $base_img = '/public/' . $base_item->company_id . '/items/' . $base_item->item_img8;
                $copy_img = '/public/' . $user->company_id . '/items/' . $base_item->item_img8;
                if (Storage::exists($base_img)) {

                    $base_item_img8 = ItemImage::where('filename', $base_item->item_img8)->where('company_id', $base_item->company_id)->first();
                    if (!is_null($base_item_img8)) {
                        $copy_item_img8 = $base_item_img8->replicate();
                        // ItemImageを検索してコピー
                        $copy_item_img8->company_id = $user->company_id;
                        // カンパニーIDだけ更新。IDやタイムスタンプは自動更新
                        $copy_item_img8->save();

                        if (Storage::exists($copy_img)) {
                            Storage::delete($copy_img);
                            Storage::copy($base_img, $copy_img);
                        } else {
                            // コピー先にファイルがなければ普通にコピー
                            Storage::copy($base_img, $copy_img);
                        }
                    }
                } else {
                    $item->item_img8 = null;
                }
            }
            if ($base_item->item_img9) {
                $base_img = '/public/' . $base_item->company_id . '/items/' . $base_item->item_img9;
                $copy_img = '/public/' . $user->company_id . '/items/' . $base_item->item_img9;
                if (Storage::exists($base_img)) {
                    $base_item_img9 = ItemImage::where('filename', $base_item->item_img9)->where('company_id', $base_item->company_id)->first();
                    if (!is_null($base_item_img9)) {
                        $copy_item_img9 = $base_item_img9->replicate();
                        // ItemImageを検索してコピー
                        $copy_item_img9->company_id = $user->company_id;
                        // カンパニーIDだけ更新。IDやタイムスタンプは自動更新
                        $copy_item_img9->save();

                        if (Storage::exists($copy_img)) {
                            Storage::delete($copy_img);
                            Storage::copy($base_img, $copy_img);
                        } else {
                            // コピー先にファイルがなければ普通にコピー
                            Storage::copy($base_img, $copy_img);
                        }
                    }
                } else {
                    $item->item_img9 = null;
                }
            }
            if ($base_item->item_img10) {
                $base_img = '/public/' . $base_item->company_id . '/items/' . $base_item->item_img10;
                $copy_img = '/public/' . $user->company_id . '/items/' . $base_item->item_img10;
                if (Storage::exists($base_img)) {
                    $base_item_img10 = ItemImage::where('filename', $base_item->item_img10)->where('company_id', $base_item->company_id)->first();
                    if (!is_null($base_item_img10)) {
                        $copy_item_img10 = $base_item_img10->replicate();
                        // ItemImageを検索してコピー
                        $copy_item_img10->company_id = $user->company_id;
                        // カンパニーIDだけ更新。IDやタイムスタンプは自動更新
                        $copy_item_img10->save();

                        if (Storage::exists($copy_img)) {
                            Storage::delete($copy_img);
                            Storage::copy($base_img, $copy_img);
                        } else {
                            // コピー先にファイルがなければ普通にコピー
                            Storage::copy($base_img, $copy_img);
                        }
                    }
                } else {
                    $item->item_img10 = null;
                    // 画像指定あるけど、画像がない場合
                }
            }
        } else {
            // 画像利用不可の場合
            $item->item_img1 = null;
            $item->item_img2 = null;
            $item->item_img3 = null;
            $item->item_img4 = null;
            $item->item_img5 = null;
            $item->item_img6 = null;
            $item->item_img7 = null;
            $item->item_img8 = null;
            $item->item_img9 = null;
            $item->item_img10 = null;
        }
        $item->save();

        // 保存したIDを取得
        $last_insert_id = $item->id;
        // Itemテーブルから見つける
        $last_insert_id = Item::find($last_insert_id);
        // ストアテーブルからカンパニーIDで見つける
        $store = Store::where('company_id', $user->company_id)->pluck('id');
        // 中間テーブルに関連づける
        $last_insert_id->store()->attach($store);

        return back()->with('success', '商品情報を登録しました');
    }

    public function CatalogTempFileDownload()
    {
        return Storage::disk('local')->download('csv_template/catalog_template.csv');
    }
}
