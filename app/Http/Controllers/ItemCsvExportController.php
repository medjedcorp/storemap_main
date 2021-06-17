<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Company;
use App\Models\Category;
use League\Csv\CharsetConverter;
use League\Csv\Writer;
use League\Csv\Reader;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //ファイルアクセス

class ItemCsvExportController extends Controller
{

  public function download()
  {
    // カテゴリDBからデータを選別
    $user = Auth::user();
    $cid = $user->company_id;

    $company = Company::find($cid);
    $m_flag = $company->maker_flag;

    // 取得する列を選択
    if ($m_flag == 1) {
      // global_flagあり
      $items = Item::where('items.company_id', '=', $cid)
        ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
        ->leftJoin('group_codes', 'group_codes.id', '=', 'items.group_code_id')
        ->leftJoin('colors', 'colors.id', '=', 'items.color_id')
        ->select(['product_code', 'product_name', 'brand_name', 'barcode', 'categories.category_code', 'original_price', 'items.display_flag', 'color_id', 'items.color_name', 'size_name', 'description', 'size', 'tag', 'group_codes.group_code', 'item_status', 'global_flag', 'storemap_category_id', 'item_img1', 'item_img2', 'item_img3', 'item_img4', 'item_img5', 'item_img6', 'item_img7', 'item_img8', 'item_img9', 'item_img10'])->get();
    } else {
      // global_flagなし
      $items = Item::where('items.company_id', '=', $cid)
        ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
        ->leftJoin('group_codes', 'group_codes.id', '=', 'items.group_code_id')
        ->leftJoin('colors', 'colors.id', '=', 'items.color_id')
        ->select(['product_code', 'product_name', 'brand_name', 'barcode', 'categories.category_code', 'original_price', 'items.display_flag', 'color_id', 'items.color_name', 'size_name', 'description', 'size','tag', 'group_codes.group_code', 'item_status', 'storemap_category_id', 'item_img1', 'item_img2', 'item_img3', 'item_img4', 'item_img5', 'item_img6', 'item_img7', 'item_img8', 'item_img9', 'item_img10'])->get();
    }
  
    $count = count($items);
    // dd($items);
    if($count === 0){
      if ($m_flag == 1) {
        return Storage::disk('local')->download('csv_template/items_m1template.csv');
      } else {
        return Storage::disk('local')->download('csv_template/items_m0template.csv');
      }
    } else {
      mb_convert_variables('sjis-win', 'UTF-8', $items);
      
      // CSVのライターを作成(新規作成)
      $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
      $csv->insertOne(array_keys($items[0]->getAttributes()));
    }

    // 文字コード変換


    // データをcsv用の配列に格納
    foreach ($items as $item) {
      $csv->insertOne($item->toArray());
    }

    return new Response($csv->getContent(), 200, [
      'Content-Encoding' => 'none',
      'Content-Type' => 'text/csv; charset=SJIS-win',
      'Content-Disposition' => 'attachment; filename="items.csv',
      'Content-Description' => 'File Transfer',
    ]);
  }

  public function ItemTempFileDownload()
  {
    $user = Auth::user();
    $cid = $user->company_id;

    $company = Company::find($cid);
    $m_flag = $company->maker_flag;

    // 取得する列を選択
    if ($m_flag == 1) {
      return Storage::disk('local')->download('csv_template/items_m1template.csv');
    } else {
      return Storage::disk('local')->download('csv_template/items_m0template.csv');
    }
  }

  public function SMCTempFileDownload()
  {
    return Storage::download('csv_template/storemap_category.xlsx');
  }
}
