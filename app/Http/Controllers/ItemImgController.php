<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //ファイルアクセス
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\StoreImage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use DB;
// use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use App\Models\Company;

class ItemImgController extends Controller
{
  public function getUpload()
  {
    return view('items/create');
  }

  public function postUpload(Request $request)
  {
    // アップロードがあったときの処理
    $user = Auth::user();
    $cid = $user->company_id;
    // Log::debug($request);

    $company = Company::where('id', $cid)->first();
    // プランを取得
    $stores = config('services.stripe.stores');
    $light = config('services.stripe.light');
    $basic = config('services.stripe.basic');
    $premium = config('services.stripe.premium');
    // 登録可能商品点数を取得
    $light_storage = config('services.stripe.light_storage');
    $basic_storage = config('services.stripe.basic_storage');
    $premium_storage = config('services.stripe.premium_storage');
    $free_storage = config('services.stripe.free_storage');

    // 有効な課金があるかチェック
    if ($company->subscribed('main')) {
      // ある場合はプラン名を代入
      $subscriptionItem = $company->subscription('main')->items->whereNotIn('stripe_plan', $stores)->first();
      $stripePlan = $subscriptionItem->stripe_plan;
    } else {
      $stripePlan = null;
    }
    // プラン名を取得
    // Log::debug('抽出', [$stripePlan]);

    // ストレージ容量を設定
    switch ($stripePlan) {
      case $light:
        $max_size = $light_storage;
        break;
      case $basic:
        $max_size = $basic_storage;
        break;
      case $premium:
        $max_size = $premium_storage;
        break;
      default:
        $max_size = $free_storage;
    }

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

      $img_size = filesize($file); // 画像容量取得
      $img_info = getimagesize($file); // 横幅、縦幅などを取得

      // 日本語や全角がある場合は強制リネーム
      $file_name1 = strlen($file_name);
      $file_name2 = mb_strlen($file_name, 'utf8');

      if ($file_name1 != $file_name2) {
        //日本語文字列が含まれている
        $file_ext = $file->getClientOriginalExtension();
        $file_name = 's' . $cid . '_' . date('YmdHis') . '.' . $file_ext;
        Storage::putFileAs('public/' . $cid . '/items/', $file, $file_name); // ストレージに保存
        // $path_as = Storage::putFileAs('public/' . $cid . '/items/', $file, $file_name); // ストレージに保存
      } else {
        Storage::putFileAs('public/' . $cid . '/items/', $file, $file_name);
        // $path_as = Storage::putFileAs('public/' . $cid . '/items/', $file, $file_name);
      }


      ItemImage::updateOrCreate(
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

    $query = \App\Models\ItemImage::query();
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

    $query = \App\Models\ItemImage::query();
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

    $query = \App\Models\ItemImage::query();
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

    $query = \App\Models\ItemImage::query();
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

    $query = \App\Models\ItemImage::query();
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

  public function ajax06(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;

    $query = \App\Models\ItemImage::query();
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

  public function ajax07(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;

    $query = \App\Models\ItemImage::query();
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

  public function ajax08(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;

    $query = \App\Models\ItemImage::query();
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

  public function ajax09(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;

    $query = \App\Models\ItemImage::query();
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

  public function ajax10(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;

    $query = \App\Models\ItemImage::query();
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
