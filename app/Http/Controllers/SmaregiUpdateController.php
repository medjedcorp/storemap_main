<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use \GuzzleHttp;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Store;
use App\Models\Item;
use Illuminate\Support\Facades\Storage; //ファイルアクセス
use Session;
use Gate;
use Log;
use League\Csv\CharsetConverter;
use League\Csv\Writer;
use League\Csv\Reader;
use Illuminate\Http\Response;

class SmaregiUpdateController extends Controller
{

  public function show(Request $request)
  {
    $user = Auth::user();
    $company = Company::where('id', $user->company_id)->first();

    $this->authorize('view', $company); // 他の人は見れないように

    $company_code = $company->company_code;
    if (isset($company->api_token)) {
      $api_token = $company->api_token;
    } else {
      $api_token = null;
    }

    // $stores = Store::where('company_id', $user->company_id)->get();
 
    // return view('config.sr-import', compact('company_code','api_token','stores'));
    return view('config.sr-update', compact('company_code', 'api_token'));
  }


  public function SmarejiTempFileDownload()
  {
    // カテゴリDBからデータを選別
    $user = Auth::user();
    $cid = $user->company_id;
    // 取得する列を選択
    $items = Item::where('company_id', '=', $cid)->where('display_flag', '1')->select(['product_code', 'barcode', 'ext_product_code'])->get();

    $count = count($items);

    if ($count === 0) {
      return Storage::disk('local')->download('csv_template/smareji_template.csv');
    } else {
      // 文字コード変換
      mb_convert_variables('sjis-win', 'UTF-8', $items);

      // CSVのライターを作成(新規作成)
      $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
      $csv->insertOne(array_keys($items[0]->getAttributes()));
    }

    // データをcsv用の配列に格納
    foreach ($items as $item) {
      $csv->insertOne($item->toArray());
    }

    return new Response($csv->getContent(), 200, [
      'Content-Encoding' => 'none',
      'Content-Type' => 'text/csv; charset=SJIS-win',
      'Content-Disposition' => 'attachment; filename="sr_codematch.csv',
      'Content-Description' => 'File Transfer',
    ]);

    //   return Storage::disk('local')->download('csv_template/smareji_template.csv');
  }
}
