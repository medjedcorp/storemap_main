<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Store;
use App\Models\Category;
use App\Models\StoremapCategory;
use App\Models\StoreUser;
use App\Models\GroupCode;
use App\Models\Company;
use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest; //バリデーション
use App\Http\Requests\ItemUpdateRequest; //バリデーション
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //ファイルアクセス
use Gate;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Arr;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ItemController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;
    $c_name = Company::where('id', $cid)->pluck('company_name')->first();
    // 検索からキーワード取得
    $keyword = $request->input('keyword');

    if ($user->role === 'admin') {
      if (isset($keyword)) {
        // カンパニーIDでセグメントしてから、orWhereのいずれかにあてはまったものを抽出
        $items = Item::where(function ($query) use ($keyword) {
          $query->orWhere('product_code', 'like', '%' . $keyword . '%')
            ->orWhere('product_name', 'like', '%' . $keyword . '%')
            ->orWhere('barcode', 'like', '%' . $keyword . '%');
        })->paginate(30);
      } else {
        $items = Item::select(['id', 'company_id', 'display_flag', 'barcode', 'product_code', 'product_name', 'original_price'])->paginate(30); // ページ作成
      }
      $count = Item::count();
    } else {
      if (isset($keyword)) {
        // カンパニーIDでセグメントしてから、orWhereのいずれかにあてはまったものを抽出
        $items = Item::where('company_id', $user->company_id)->where(function ($query) use ($keyword) {
          $query->orWhere('product_code', 'like', '%' . $keyword . '%')
            ->orWhere('product_name', 'like', '%' . $keyword . '%')
            ->orWhere('barcode', 'like', '%' . $keyword . '%');
        })->paginate(30);
      } else {
        $items = Item::select(['id', 'company_id', 'display_flag', 'barcode', 'product_code', 'product_name', 'original_price'])->where('company_id', $user->company_id)->paginate(30); // ページ作成
      }
      $count = Item::where('company_id', $user->company_id)->count();
    }

    return view('items.index', [
      'items' => $items,
      'keyword' => $keyword,
      'count' => $count,
      'c_name' => $c_name,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $user = Auth::user();
    $company = DB::table('companies')->where('id', $user->company_id)->first();
    $colors = Color::all();
    $category = Category::where('company_id', $user->company_id)->orderBy('category_name', 'asc')->get();
    $first_layer = StoremapCategory::whereIsRoot('parent_id', '=', 'null')->orderBy('smcategory_name', 'asc')->get();
    // dd($colors);
    return view('items.create', compact('user', 'category', 'first_layer', 'company', 'colors'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(ItemRequest $request)
  {
    $user = Auth::user();
    $item = new Item;
    if ($user->role === "admin") {
      $item->company_id = $request->company_id;
    } else {
      $item->company_id = $user->company_id;
    }
    $item->global_flag = $request->global_flag;
    $item->barcode = $request->barcode;
    $item->product_code = $request->product_code;
    $item->product_name = $request->product_name;
    $item->category_id = $request->category_id;
    $item->display_flag = $request->display_flag;
    $item->original_price = $request->original_price;
    $item->description = $request->description;
    $item->brand_name = $request->brand_name;
    $item->size = $request->size;
    $item->size_name = $request->size_name;
    $item->color_name = $request->color_name;
    $item->color_id = $request->color_id;
    $item->tag = $request->tag;

    $smid = Arr::last($request->storemap_category_id, function ($value, $key) {
      return $value != null;
    });
    $item->storemap_category_id = $smid;

    $item->item_status = $request->item_status;
    $item->item_img1 = $request->item_img1;
    $item->item_img2 = $request->item_img2;
    $item->item_img3 = $request->item_img3;
    $item->item_img4 = $request->item_img4;
    $item->item_img5 = $request->item_img5;
    $item->item_img6 = $request->item_img6;
    $item->item_img7 = $request->item_img7;
    $item->item_img8 = $request->item_img8;
    $item->item_img9 = $request->item_img9;
    $item->item_img10 = $request->item_img10;
    $gc = $request->group_code;

    // グループコードがテーブルに存在するかチェックして、booleanで戻す
    if ($user->role === "admin") {
      $group = DB::table('group_codes')->where('company_id', $request->company_id)->where('group_code', $gc)->exists();
    } else {
      $group = DB::table('group_codes')->where('company_id', $user->company_id)->where('group_code', $gc)->exists();
    }


    if ($group) {
      //グループコードがDBにある場合
      if ($user->role === "admin") {
        $gid = GroupCode::where('company_id', $request->company_id)->where('group_code', $gc)->first();
      } else {
        $gid = GroupCode::where('company_id', $user->company_id)->where('group_code', $gc)->first();
      }
      $item->group_code_id = $gid->id;
    } elseif (!$group && isset($gc)) {
      //グループコードがなくて、コードが入力されている場合の処理
      $gcd = new GroupCode;
      $gcd->group_code = $gc;
      if ($user->role === "admin") {
        $gcd->company_id = $request->company_id;
      } else {
        $gcd->company_id = $user->company_id;
      }
      $gcd->save();
      // 保存したIDを取得
      $last_insert_id = $gcd->id;
      $item->group_code_id = $last_insert_id;
    } else {
      //グループコード未記入の場合の処理
      $item->group_code_id = $gc;
    }

    $item->save();


    // 保存したIDを取得
    $last_insert_id = $item->id;
    // Itemテーブルから見つける
    $last_insert_id = Item::find($last_insert_id);
    // ストアテーブルからカンパニーIDで見つける
    $store = Store::where('company_id', $item->company_id)->pluck('id');
    // 中間テーブルに関連づける

    $last_insert_id->store()->attach($store);
    return redirect()->action('ItemController@edit', [$item->id])->with('success', '※' . $item->product_code . 'を登録しました');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Item  $item
   * @return \Illuminate\Http\Response
   */
  // public function show($id)
  // {
  //     $item = Item::find($id);
  //     $user = Auth::user();
  //     $category = DB::table('categories')->where('id', $user->company_id)->get();
  //
  //     return view('items.edit', compact('item', 'user', 'category'));
  // }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $item = Item::find($id);

    // 権限設定ポリシー。会社ID違うと見れない
    $this->authorize('view', $item);

    $user = Auth::user();
    $colors = Color::all();
    
    // $store = Store::where('company_id', $user->company_id)->orderBy('store_name', 'asc')->get();
    $store = Store::where('company_id', $item->company_id)->orderBy('store_name', 'asc')->get();
    $first_layer = StoremapCategory::whereIsRoot('parent_id', '=', 'null')->orderBy('smcategory_name', 'asc')->get();
    $result = StoremapCategory::ancestorsAndSelf($item->storemap_category_id);
    $smcate = $result->implode('smcategory_name', ' > ');
    // $company = DB::table('companies')->where('id', $user->company_id)->pluck('id','maker_flag');
    $company = Company::where('id', $item->company_id)->select('id', 'maker_flag')->first();

    // $img_name = Str::afterLast($item->sku_item_image, '/');
    // 価格設定
    $itemprice = Item::find($id)->store;
    // dd($itemprice);
    // if (Gate::allows('admin-higher')) { //管理者権限で全店表示
    //     // 中間テーブルを含め全部データ取得してるんで、軽くできるはず...
    //
    //
    // } else { // 担当者権限：保持店舗のみ表示
    //
    // }

    // $category = DB::table('categories')->where('company_id', $user->company_id)->get();
    $category = Category::where('company_id', $item->company_id)->get();
    if (!isset($category)) {
      $category = null;
    }

    // $is_img = '/storage/'. $user->company_id .'/images/'. $item->sku_item_image;
    // $img_name = $item->sku_item_image;
    // return view('items.edit', compact('item', 'user', 'category', 'store', 'itemprice', 'is_img', 'first_layer', 'smcate', 'company' ,'img_name'));
    return view('items.edit', compact('item', 'user', 'category', 'store', 'itemprice', 'first_layer', 'smcate', 'company', 'colors'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function update(ItemUpdateRequest $request)
  {
    $user = Auth::user();

    $item = Item::find($request->id);

    // 権限設定ポリシー。会社ID違うと見れない
    $this->authorize('update', $item);

    if ($user->role === "admin") {
      $item->company_id = $request->company_id;
    } else {
      $item->company_id = $user->company_id;
    }
   
    $item->barcode = $request->barcode;
    $item->global_flag = $request->global_flag;
    $item->product_code = $request->product_code;
    $item->product_name = $request->product_name;
    $item->category_id = $request->category_id;
    $item->display_flag = $request->display_flag;
    $item->original_price = $request->original_price;
    $item->description = $request->description;
    $item->brand_name = $request->brand_name;
    $item->size = $request->size;
    $item->size_name = $request->size_name;
    $item->color_name = $request->color_name;
    $item->color_id = $request->color_id;
    $item->tag = $request->tag;
    // $item->group_code_id = $request->group_code_id;
    // dd($request->storemap_category_id);
    $smid = Arr::last($request->storemap_category_id, function ($value, $key) {
      // 配列の最後の値を渡す。nullじゃない
      return $value != null;
    });
    $item->storemap_category_id = $smid;
    $item->item_status = $request->item_status;
    $item->item_img1 = $request->item_img1;
    $item->item_img2 = $request->item_img2;
    $item->item_img3 = $request->item_img3;
    $item->item_img4 = $request->item_img4;
    $item->item_img5 = $request->item_img5;
    $item->item_img6 = $request->item_img6;
    $item->item_img7 = $request->item_img7;
    $item->item_img8 = $request->item_img8;
    $item->item_img9 = $request->item_img9;
    $item->item_img10 = $request->item_img10;

    $gc = $request->group_code;

    if ($user->role === "admin") {
      $group = DB::table('group_codes')->where('company_id', $request->company_id)->where('group_code', $gc)->exists();
    } else {
      $group = DB::table('group_codes')->where('company_id', $user->company_id)->where('group_code', $gc)->exists();
    }

    if ($group) {
      //グループコードがある場合
      if ($user->role === "admin") {
        $gid = GroupCode::where('company_id', $request->company_id)->where('group_code', $request->group_code)->first();
      } else {
        $gid = GroupCode::where('company_id', $user->company_id)->where('group_code', $request->group_code)->first();
      }

      $item->group_code_id = $gid->id;
    } elseif (!$group && isset($gc)) {
      // グループコードに登録がなくて、グループコードが入力されている場合の処理
      $gcd = new GroupCode;
      $gcd->group_code = $request->group_code;
      if ($user->role === "admin") {
        $gcd->company_id = $request->company_id;
      } else {
        $gcd->company_id = $user->company_id;
      }
      $gcd->save();
      // 保存したIDを取得
      $last_insert_id = $gcd->id;
      $item->group_code_id = $last_insert_id;
    } else {
      //グループコード未記入の場合の処理
      $item->group_code_id = $gc;
    }

    $item->save();
    return redirect()->action('ItemController@edit', [$item->id])->with('success', '※' . $item->product_code . 'を更新しました');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Item  $item
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $item = Item::find($id);

    // Gate::authorize('isSeller'); // gate staffは削除不可
    // 権限設定ポリシー。会社ID違うと見れない
    $this->authorize('delete', $item);

    $item->delete();
    return redirect("/items")->with([
      'danger' => '※' . $item->product_code . ' を削除しました',
    ]);
  }
}
