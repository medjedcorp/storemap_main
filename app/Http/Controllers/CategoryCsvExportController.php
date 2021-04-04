<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use League\Csv\CharsetConverter;
use League\Csv\Writer;
use League\Csv\Reader;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //ファイルアクセス

class CategoryCsvExportController extends Controller
{

  public function download()
  {
    // カテゴリDBからデータを選別
    $user = Auth::user();
    $cid = $user->company_id;
    // 取得する列を選択
    $categories = Category::where('company_id', '=', $cid)->select(['category_code', 'category_name', 'display_flag'])->get();


    $count = count($categories);

    if ($count === 0) {
      return Storage::disk('local')->download('csv_template/categories_template.csv');
    } else {
      // 文字コード変換
      mb_convert_variables('sjis-win', 'UTF-8', $categories);

      // CSVのライターを作成(新規作成)
      $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
      $csv->insertOne(array_keys($categories[0]->getAttributes()));
    }

    // データをcsv用の配列に格納
    foreach ($categories as $category) {
      $csv->insertOne($category->toArray());
    }

    return new Response($csv->getContent(), 200, [
      'Content-Encoding' => 'none',
      'Content-Type' => 'text/csv; charset=SJIS-win',
      'Content-Disposition' => 'attachment; filename="categories.csv',
      'Content-Description' => 'File Transfer',
    ]);
  }

  public function CateTempFileDownload()
  {
    return Storage::disk('local')->download('csv_template/categories_template.csv');
  }
}
