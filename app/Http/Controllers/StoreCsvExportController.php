<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Category;
use League\Csv\CharsetConverter;
use League\Csv\Writer;
use League\Csv\Reader;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //ファイルアクセス

class StoreCsvExportController extends Controller
{
    public function download()
    {
        // カテゴリDBからデータを選別
        $user = Auth::user();
        $cid = $user->company_id;

        // 取得する列を選択
        $stores = Store::where('company_id', '=', $cid)
            ->select(['store_code', 'store_name', 'store_kana', 'store_postcode', 'prefecture', 'store_city', 'store_adnum', 'store_apart', 'store_phone_number', 'store_fax_number', 'store_email', 'pause_flag', 'store_img1', 'store_img2', 'store_img3', 'store_img4', 'store_img5', 'store_info', 'industry_id', 'store_url', 'flyer_img', 'floor_guide', 'pay_info', 'access', 'opening_hour', 'closed_day', 'parking'])->get();

        // $stores = Store::where('items.company_id', '=', $cid)
        // ->leftJoin('categories','categories.id','=','items.category_id')
        // ->leftJoin('group_codes','group_codes.id','=','items.group_code_id')
        // ->select(['product_code', 'product_name', 'barcode', 'categories.category_code', 'original_price', 'items.display_flag', 'description', 'size', 'color', 'tag', 'group_codes.group_code', 'item_status', 'storemap_category_id', 'sku_item_image'])->get();


        $count = count($stores);

        if ($count === 0) {
            return Storage::disk('local')->download('csv_template/stores_template.csv');
        } else {
            // 文字コード変換
            mb_convert_variables('sjis-win', 'UTF-8', $stores);

            // CSVのライターを作成(新規作成)
            $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
            $csv->insertOne(array_keys($stores[0]->getAttributes()));
        }



        // データをcsv用の配列に格納
        foreach ($stores as $store) {
            $csv->insertOne($store->toArray());
        }

        return new Response($csv->getContent(), 200, [
            'Content-Encoding' => 'none',
            'Content-Type' => 'text/csv; charset=SJIS-win',
            'Content-Disposition' => 'attachment; filename="stores.csv',
            'Content-Description' => 'File Transfer',
        ]);
    }

    public function StoreTempFileDownload()
    {
        return Storage::disk('local')->download('csv_template/stores_template.csv');
    }
}
