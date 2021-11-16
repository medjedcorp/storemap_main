<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage; //ファイルアクセス
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\StoreImage;
use Gate;

class AlbumStoreController extends Controller
{

  public function index(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;
    $c_name = Company::where('id', $cid)->pluck('company_name')->first();

    $path_as = $cid . '/stores/';

    $count = StoreImage::where('company_id', $cid)->get()->count();
    // $count = count($images);
    $total_bytes_value = StoreImage::where('company_id', $cid)->sum('size');
    // 画像総容量をギガバイト数に変換
    $total_gbytes = number_format($total_bytes_value / 1073741824, 2) . ' GB';

    // 検索からキーワード取得
    $keyword = $request->input('keyword');
    if (isset($keyword)) {
      // カンパニーIDでセグメントしてから、orWhereのいずれかにあてはまったものを抽出
      $images = StoreImage::select(['id', 'filename', 'size', 'width', 'height', 'updated_at'])->where('company_id', $cid)->where('filename', 'like', '%' . $keyword . '%')->sortable()->paginate(20);
    } else {
      $images = StoreImage::select(['id', 'filename', 'size', 'width', 'height', 'updated_at'])->where('company_id', $cid)->sortable()->paginate(20); // ページ作成

    }

    // $img_path = Storage::disk('public')->files($path_as); // フォルダ内の画像のすべてのパス取得
    // $img_list = [];
    // $total_bytes_value = 0;
    // $count = count($img_path);

    // foreach ($img_path as $img) { //データを形成
    //     $img_size = Storage::disk('public')->size($img); // ファイル容量抽出
    //     $bytes = number_format($img_size / 1024, 0) . ' KB'; // kbに変換
    //     $modified = Storage::disk('public')->lastModified($img); // ファイル最終更新日
    //     $modified_time = date('Y-m-d H:i', $modified); // 日時変換
    //     $img_url  = Storage::disk('public')->url($img); // URL 絶対パス 取得
    //     $img_info = getimagesize(asset('storage/'. $img)); // 横幅、縦幅などを取得
    //     $img_name = Str::afterLast($img, '/'); // 最後のスラッシュより後の文字列を取得。ファイル名
    //     $img_list[] = [ // 配列作成
    //       "size" => $bytes,
    //       "last_update" => $modified_time,
    //       "path" => $img,
    //       "url" => $img_url,
    //       "width" => $img_info[0],
    //       "height" => $img_info[1],
    //       "name" => $img_name,
    //     ];
    //     $total_bytes_value += $img_size; // 画像の容量を加算
    // }

    // $img_lists = collect($img_list); // 配列をコレクションに変換



    // $images = new LengthAwarePaginator( // ページネーション作成
    //         $img_lists->forPage($request->page, 20), // 20単位
    //         count($img_lists), // 総数取得
    //         20, // 20に区切る
    //         $request->page,
    //         ['path' => $request->url()]
    //     );

    // // 検索からキーワード取得
    // $keyword = $request->input('keyword');
    // if (isset($keyword)) {
    //     $img_lists = $img_lists->filter(function ($img_lists) use ($keyword) {
    //         return strpos($img_lists['name'], $keyword) !== false; // ファイル名で検索
    //     });
    //
    //     $images = new LengthAwarePaginator( // ページネーション作成
    //             $img_lists->forPage($request->page, 20), // 20単位
    //             count($img_lists), // 総数取得
    //             20, // 20に区切る
    //             $request->page,
    //             ['path' => $request->url()]
    //         );
    // }
    return view('album.stores', [
      'images' => $images,
      'keyword' => $keyword,
      'total_gbytes' => $total_gbytes,
      'c_name' => $c_name,
      'count' => $count,
      'path_as' => $path_as,
    ]);
  }


  // public function postUpload(Request $request)
  // {
  //     $user = Auth::user();
  //     $cid = $user->company_id;
  //     $file = $request->file('file'); // ファイル受け取る
  //     $file_name = $file->getClientOriginalName(); // ファイル名はアップロードされたのをそのまま使用
  //     $path_as = Storage::putFileAs('public/'.$cid.'/images/',$request->file('file'), $file_name); // ストレージに保存
  // }

  public function destroy(StoreImage $storeimage, Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;

    Gate::authorize('isFree'); // gate staffは削除不可

    $img_id = $request->img_id;
    foreach ($img_id as $img) {
      $storeimage = StoreImage::where('company_id', $cid)->where('id', $img)->first();

      // 権限設定ポリシー。会社ID違うと見れない
      $this->authorize('delete', $storeimage);

      $img_name = $storeimage->filename;
      // $img_name = Str::afterLast($img, '/');
      // 最後のスラッシュより後の文字列を取得。ファイル名取得
      $path_as = $cid . '/stores/' . $img_name;
      Storage::disk('public')->delete($path_as);
      // ItemImage::where('company_id', $user->$cid)->where('filename', $img_name)->delete();
      $storeimage->delete();
    }

    // dd($simg_path);
    // Session::flash('success', '※登録しました');
    return back()->with('danger', '※画像を削除しました');
    // return redirect('/seller/album')->with('result', '※削除しました');
  }
}
