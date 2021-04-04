<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\CsvFileImportService;
use Illuminate\Http\File;
use App\Jobs\CateImportCsvJob;
use Illuminate\Support\Facades\Auth;
use App\Jobs\CsvFileDeleteJob;
use App\Http\Controllers\Controller;
use App\Models\Category;
use League\Csv\Reader;
use League\Csv\Statement;

class CategoryCsvImportController extends Controller
{
  protected $csv_service;

  public function __construct(Request $request)
  {
    // クラスCSVサービスを使うよ定義？
    $this->csv_service = new CsvFileImportService();
  }

  public function importCateCSV(Request $request)
  {
    // ジョブに渡すためのユーザ情報
    $user = Auth::user();
    $cid  = $user->company_id;

    // アップロードファイルに対してのバリデート。Serviceの呼び出し
    $validator = $this->csv_service->validateUploadFile($request);


    if ($validator->fails() === true) {
      // アップロードファイル自体にエラーがあれば出力
      return redirect('/categories/data')->with('danger', $validator->errors()->first('file'));
    }

    $upload_filename = $request->file('file')->getClientOriginalName();
    $file = $request->file('file');
    $filename = 'categories_' . $cid . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();

    // ファイルをフォルダに保存
    $csv_path = $file->storeAs(
      'csv/' . $cid . '/import',
      $filename
      // 'public/'.$cid.'/csv/import/', $filename
    );

    // Queueに送信
    CateImportCsvJob::dispatch($upload_filename, $filename, $user, $csv_path);
    // 60分後にファイル削除
    CsvFileDeleteJob::dispatch($csv_path)->delay(now()->addMinutes(60));

    return redirect('/categories/data')->with('success', 'CSVデータを読み込みました。処理結果はメールでお知らせ致します');
  }
}
