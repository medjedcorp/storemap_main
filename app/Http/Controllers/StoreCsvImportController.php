<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\CsvFileImportService;
use Illuminate\Http\File;
use App\Jobs\StoreImportCsvJob;
use Illuminate\Support\Facades\Auth;
use App\Jobs\CsvFileDeleteJob;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Company;
use League\Csv\Reader;
use League\Csv\Statement;

class StoreCsvImportController extends Controller
{
  protected $csv_service;

  public function __construct(Request $request)
  {
      // クラスCSVサービスを使うよ定義？
      $this->csv_service = new CsvFileImportService();
  }

  public function importStoreCSV(Request $request)
  {
    // ジョブに渡すためのユーザ情報
    $user = Auth::user();
    $cid  = $user->company_id;
    
    // 登録可能店舗数を取得
    $company = Company::where('id', $user->company_id)->first();
    $stores = config('services.stripe.stores');
    // ストア数のプランを取得
    $storesItem = $company->subscription('main')->items->where('stripe_plan', $stores)->first();
    $quantity = $storesItem->quantity;
    // 取得した値に1プラスしたのが登録可能店舗数
    $quantity = $quantity + 1;

    // アップロードファイルに対してのバリデート。Serviceの呼び出し
    $validator = $this->csv_service->validateUploadFile($request);

    if ($validator->fails() === true){
      // アップロードファイル自体にエラーがあれば出力
        return redirect('/stores/data')->with('message', $validator->errors()->first('file'));
    }

    $upload_filename = $request->file('file')->getClientOriginalName();
    $file = $request->file('file');
    $filename = 'stores_'. $cid . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();

    // ファイルをフォルダに保存
    $csv_path = $file->storeAs(
          'csv/'.$cid.'/import', $filename
    );
    // Queueに送信
    StoreImportCsvJob::dispatch($upload_filename, $filename, $user, $csv_path, $quantity);
    // 60分後にファイル削除
    CsvFileDeleteJob::dispatch($csv_path)->delay(now()->addMinutes(60));

    return redirect('/stores/data')->with('success', 'CSVデータを読み込みました。処理結果はメールでお知らせ致します');

  }
}
