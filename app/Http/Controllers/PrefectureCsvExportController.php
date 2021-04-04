<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prefecture;
use League\Csv\CharsetConverter;
use League\Csv\Writer;
use League\Csv\Reader;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //ファイルアクセス

class PrefectureCsvExportController extends Controller
{

  public function download()
  {
    // カテゴリDBからデータを選別
    $user = Auth::user();
    // 取得する列を選択
    $prefs = Prefecture::selectRaw("code,region,city,ward,ST_X( location ) As latitude, ST_Y( location ) As longitude")->get();

    // 文字コード変換
    mb_convert_variables('sjis-win', 'UTF-8', $prefs);

    // CSVのライターを作成(新規作成)
    $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
    $csv->insertOne(array_keys($prefs[0]->getAttributes()));

    // データをcsv用の配列に格納
    foreach ($prefs as $pref) {
    $csv->insertOne($pref->toArray());
    }

    return new Response($csv->getContent(), 200, [
        'Content-Encoding' => 'none',
        'Content-Type' => 'text/csv; charset=SJIS-win',
        'Content-Disposition' => 'attachment; filename="prefectures.csv',
        'Content-Description' => 'File Transfer',
    ]);
  }
  
}
