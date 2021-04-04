<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\CsvFileImportService;
use Illuminate\Http\File;
use App\Jobs\ItemImportCsvJob;
use Illuminate\Support\Facades\Auth;
use App\Jobs\CsvFileDeleteJob;
use App\Http\Controllers\Controller;
use App\Models\Item;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Models\Company;

class ItemCsvImportController extends Controller
{
  protected $csv_service;

  public function __construct(Request $request)
  {
    // クラスCSVサービスを使うよ定義？
    $this->csv_service = new CsvFileImportService();
  }

  public function importItemCSV(Request $request)
  {
    // ジョブに渡すためのユーザ情報
    $user = Auth::user();
    $cid  = $user->company_id;

    // プランを取得
    $company = Company::where('id', $cid)->first();
    $stores = config('services.stripe.stores');
    $light = config('services.stripe.light');
    $basic = config('services.stripe.basic');
    $premium = config('services.stripe.premium');
    // 登録可能商品点数を取得
    $light_item = config('services.stripe.light_item');
    $basic_item = config('services.stripe.basic_item');
    $premium_item = config('services.stripe.premium_item');
    // ストア数プラン以外で、引っかかるプランを取得(店舗数)
    $subscriptionItem = $company->subscription('main')->items->whereNotIn('stripe_plan', $stores)->first();
    // プラン名を取得
    $stripePlan = $subscriptionItem->stripe_plan;

    switch ($stripePlan) {
      case $light:
        $max_item = $light_item;
        break;
      case $basic:
        $max_item = $basic_item;
        break;
      case $premium:
        $max_item = $premium_item;
        break;
      default:
        $max_item = 0;
    }

    // アップロードファイルに対してのバリデート。Serviceの呼び出し
    $validator = $this->csv_service->validateUploadFile($request);

    if ($validator->fails() === true) {
      // アップロードファイル自体にエラーがあれば出力
      return redirect('/items/data')->with('message', $validator->errors()->first('file'));
    }

    $upload_filename = $request->file('file')->getClientOriginalName();
    $file = $request->file('file');
    $filename = 'items_' . $cid . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();

    // ファイルをフォルダに保存
    $csv_path = $file->storeAs(
      'csv/' . $cid . '/import', $filename
    );
    // Queueに送信
    ItemImportCsvJob::dispatch($upload_filename, $filename, $user, $csv_path, $max_item);
    // 60分後にファイル削除
    CsvFileDeleteJob::dispatch($csv_path)->delay(now()->addMinutes(60));

    return redirect('/items/data')->with('success', 'CSVデータを読み込みました。処理結果はメールでお知らせ致します');
  }
}
