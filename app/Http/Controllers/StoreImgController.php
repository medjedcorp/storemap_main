<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //ファイルアクセス
use App\Models\Store;
use App\Models\Company;
use App\Models\ItemImage;
use App\Models\StoreImage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use DB;
// use Log;
use Illuminate\Http\Response;

class StoreImgController extends Controller
{
  public function getUpload()
  {
    return view('stores/create');
  }

  public function postUpload(Request $request)
  {
    $user = Auth::user();
    
    // Log::debug($request);
    if ($user->role === "admin") {
      $cid = $request->company_id;
    } else {
      $cid = $user->company_id;
    }
    $max_size = maxImgCap($user);

    $files = $request->file();

    foreach ($files as $file) {
      // 登録可能件数を超えた場合のエラー処理
      // 現在の画像容量を計算
      $item_size = ItemImage::where('company_id', $cid)->sum('size');
      $store_size = StoreImage::where('company_id', $cid)->sum('size');
      $total_size = $item_size + $store_size;

      if ($max_size <= $total_size) {
        return response()->json(['error' => '容量オーバーのため中止しました'],400);
      }

      $file_name = $file->getClientOriginalName(); // ファイル名はアップロードされたのをそのまま使用

      $img_size = filesize($file);
      $img_info = getimagesize($file); // 横幅、縦幅などを取得


      // 日本語や全角がある場合は強制リネーム
      $file_name1 = strlen($file_name);
      $file_name2 = mb_strlen($file_name, 'utf8');

      if ($file_name1 != $file_name2) {
        //日本語文字列が含まれている
        $file_ext = $file->getClientOriginalExtension();
        $file_name = 's' . $cid . '_' . date('YmdHis') . '.' . $file_ext;
        Storage::putFileAs('public/' . $cid . '/stores/', $file, $file_name); // ストレージに保存
        // $path_as = Storage::putFileAs('public/' . $cid$cid . '/stores/', $file, $file_name); // ストレージに保存
        // Storage::disk('uploads')->put("stores/$cid",  $file, $file_name);
      } else {
        Storage::putFileAs('public/' . $cid . '/stores/', $file, $file_name);
        // $path_as = Storage::putFileAs('public/' . $cid . '/stores/', $file, $file_name);
        // Storage::disk('uploads')->put("stores/$cid",  $file, $file_name);
      }

      StoreImage::updateOrCreate(
        // カテゴリを検索
        ['company_id' => $cid, 'filename' => $file_name],
        // データがない場合は新規登録、ある場合は更新
        [
          'company_id' => $cid,
          'filename' => $file_name,
          'size' => $img_size,
          "width" => $img_info[0],
          "height" => $img_info[1],
        ]
      );

      return response()->json(['success' => $file_name]);
    }
  }

  public function ajax01(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;

    $query = \App\Models\StoreImage::query();
    $query->where('company_id', $cid);

    if ($request->filled('q')) {
      $keywords = explode(' ', trim(mb_convert_kana($request->q, 's')));
      foreach ($keywords as $keyword) {
        $query->where('filename', 'LIKE', '%' . $keyword . '%');
      }
    }
    $per_page = 10;
    return $query->paginate($per_page);
  }

  public function ajax02(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;

    $query = \App\Models\StoreImage::query();
    $query->where('company_id', $cid);

    if ($request->filled('q')) {
      $keywords = explode(' ', trim(mb_convert_kana($request->q, 's')));
      foreach ($keywords as $keyword) {
        $query->where('filename', 'LIKE', '%' . $keyword . '%');
      }
    }
    $per_page = 10;
    return $query->paginate($per_page);
  }

  public function ajax03(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;

    $query = \App\Models\StoreImage::query();
    $query->where('company_id', $cid);

    if ($request->filled('q')) {
      $keywords = explode(' ', trim(mb_convert_kana($request->q, 's')));
      foreach ($keywords as $keyword) {
        $query->where('filename', 'LIKE', '%' . $keyword . '%');
      }
    }
    $per_page = 10;
    return $query->paginate($per_page);
  }

  public function ajax04(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;

    $query = \App\Models\StoreImage::query();
    $query->where('company_id', $cid);

    if ($request->filled('q')) {
      $keywords = explode(' ', trim(mb_convert_kana($request->q, 's')));
      foreach ($keywords as $keyword) {
        $query->where('filename', 'LIKE', '%' . $keyword . '%');
      }
    }
    $per_page = 10;
    return $query->paginate($per_page);
  }

  public function ajax05(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;

    $query = \App\Models\StoreImage::query();
    $query->where('company_id', $cid);

    if ($request->filled('q')) {
      $keywords = explode(' ', trim(mb_convert_kana($request->q, 's')));
      foreach ($keywords as $keyword) {
        $query->where('filename', 'LIKE', '%' . $keyword . '%');
      }
    }
    $per_page = 10;
    return $query->paginate($per_page);
  }
}
