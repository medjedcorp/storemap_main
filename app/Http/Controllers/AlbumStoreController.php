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
    // 検索からキーワード取得
    $keyword = $request->input('keyword');
    if (isset($keyword)) {
      // $images = StoreImage::select(['id', 'filename', 'size', 'width', 'height', 'updated_at'])->where('company_id', $cid)->where('filename', 'like', '%' . $keyword . '%')->sortable()->paginate(20);
      if ($user->role === "admin") {
        // adminはcompany_id でのみの検索
        $cid = $keyword;
        $images = StoreImage::select(['id', 'filename', 'size', 'width', 'height', 'updated_at'])->where('company_id', $cid)->sortable()->paginate(20);
      } else {
        // カンパニーIDでセグメントしてから、orWhereのいずれかにあてはまったものを抽出
        $images = StoreImage::select(['id', 'filename', 'size', 'width', 'height', 'updated_at'])->where('company_id', $cid)->where('filename', 'like', '%' . $keyword . '%')->sortable()->paginate(20);
      }
    } else {
      $images = StoreImage::select(['id', 'filename', 'size', 'width', 'height', 'updated_at'])->where('company_id', $cid)->sortable()->paginate(20); // ページ作成
    }

    $c_name = Company::where('id', $cid)->pluck('company_name')->first();

    $path_as = $cid . '/stores/';

    $count = StoreImage::where('company_id', $cid)->get()->count();
    // $count = count($images);
    $total_bytes_value = StoreImage::where('company_id', $cid)->sum('size');
    // 画像総容量をギガバイト数に変換
    $total_gbytes = number_format($total_bytes_value / 1073741824, 2) . ' GB';

    return view('album.stores', [
      'images' => $images,
      'keyword' => $keyword,
      'total_gbytes' => $total_gbytes,
      'c_name' => $c_name,
      'count' => $count,
      'path_as' => $path_as,
    ]);
  }


  public function destroy(StoreImage $storeimage, Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;

    Gate::authorize('isFree'); // gate staffは削除不可

    $img_id = $request->img_id;
    foreach ($img_id as $img) {
      if ($user->role === "admin") {
        $storeimage = StoreImage::where('id', $img)->first();
        $cid = $storeimage->company_id;
      } else {
        $storeimage = StoreImage::where('company_id', $cid)->where('id', $img)->first();
      }
      
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
