<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoremapCategory;
use League\Csv\CharsetConverter;
use League\Csv\Writer;
use League\Csv\Reader;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //ファイルアクセス

class SmCategoryCsvExportController extends Controller
{

  public function download()
  {
    // カテゴリDBからデータを選別
    $user = Auth::user();
    // 取得する列を選択
    $smcategories = StoremapCategory::select(['id', 'smcategory_name', 'parent_id'])->get();

    // 文字コード変換
    mb_convert_variables('sjis-win', 'UTF-8', $smcategories);

    // CSVのライターを作成(新規作成)
    $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
    $csv->insertOne(array_keys($smcategories[0]->getAttributes()));

    // データをcsv用の配列に格納
    foreach ($smcategories as $smcategory) {
    $csv->insertOne($smcategory->toArray());
    }

    return new Response($csv->getContent(), 200, [
        'Content-Encoding' => 'none',
        'Content-Type' => 'text/csv; charset=SJIS-win',
        'Content-Disposition' => 'attachment; filename="sm_categories.csv',
        'Content-Description' => 'File Transfer',
    ]);
  }

  public function template_download()
  {
    // カテゴリDBからデータを選別
    $user = Auth::user();
    // 取得する列を選択
    $smcategories = StoremapCategory::select(['id', 'smcategory_name', 'parent_id'])->get();

    // 文字コード変換
    mb_convert_variables('sjis-win', 'UTF-8', $smcategories);

    // CSVのライターを作成(新規作成)
    $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
    $csv->insertOne(array_keys($smcategories[0]->getAttributes()));

    // データをcsv用の配列に格納
    foreach ($smcategories as $smcategory) {
    $csv->insertOne($smcategory->toArray());
    }

    return new Response($csv->getContent(), 200, [
        'Content-Encoding' => 'none',
        'Content-Type' => 'text/csv; charset=SJIS-win',
        'Content-Disposition' => 'attachment; filename="sm_categories.csv',
        'Content-Description' => 'File Transfer',
    ]);
  }
}
