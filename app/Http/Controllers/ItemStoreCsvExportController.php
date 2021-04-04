<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Store;
use App\Models\ItemStore;
use League\Csv\CharsetConverter;
use League\Csv\Writer;
use League\Csv\Reader;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //ファイルアクセス

class ItemStoreCsvExportController extends Controller
{

  public function download()
  {
    // カテゴリDBからデータを選別
    $user = Auth::user();
    $cid = $user->company_id;

    // 取得する列を選択
    // $item_store = DB::table('item_store')
    $item_store = ItemStore::leftJoin('items', 'items.id', '=', 'item_store.item_id')
      // ->leftJoin('items','items.id','=','item_store.item_id')
      ->leftJoin('stores', 'stores.id', '=', 'item_store.store_id')
      ->where('items.company_id', '=', $cid)
      ->select(['items.product_code', 'stores.store_code', 'price_type', 'price', 'value', 'start_date', 'end_date', 'sort_num', 'stock_amount', 'stock_set', 'catch_copy', 'shelf_number', 'selling_flag'])->get();
    // dd($item_store);
    // 文字コード変換

    $count = count($item_store);

    if ($count === 0) {
      return Storage::disk('local')->download('csv_template/management_template.csv');
    } else {
      mb_convert_variables('sjis-win', 'UTF-8', $item_store);

      // CSVのライターを作成(新規作成)
      $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
      $csv->insertOne(array_keys($item_store[0]->getAttributes()));
    }


    // データをcsv用の配列に格納
    foreach ($item_store as $value) {
      $csv->insertOne($value->toArray());
    }

    return new Response($csv->getContent(), 200, [
      'Content-Encoding' => 'none',
      'Content-Type' => 'text/csv; charset=SJIS-win',
      'Content-Disposition' => 'attachment; filename="management.csv',
      'Content-Description' => 'File Transfer',
    ]);
  }

  public function ItemStoreTempFileDownload()
  {
    return Storage::disk('local')->download('csv_template/management_template.csv');
  }
}
