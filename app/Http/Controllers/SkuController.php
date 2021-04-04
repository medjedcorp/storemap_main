<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Company;
use App\Models\GroupCode;
use App\Models\Item;
use App\Models\Store;
use App\Models\ItemStore;
use App\Models\Color;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
// use Carbon\Carbon;

class SkuController extends Controller
{
    public function index(Request $request, $sid, $icode)
    {
        // 検索からキーワード取得
        // $keyword = $request->input('keyword');

        // 表示用商品取得
        // dd($request);
        $item_code = $icode;
        $store_id = $sid;

        $store_info = Store::find($sid);
        // $store = Store::find($store_id);
        // $item = Item::find($item_id);
        $item = Item::where('product_code', $item_code)->where('company_id', $store_info->company_id)->first();
        $sku = ItemStore::where('store_id', $store_id)->where('item_id', $item->id)->first();
        // dd($sku);
        if ($item->group_code_id) {

            $valiations = DB::table('items')
            ->where('company_id', $item->company_id)
            ->where('group_code_id', $item->group_code_id)
            ->leftJoin('colors', 'items.color_id', '=', 'colors.id')
            ->leftJoin('item_store', 'items.id', '=', 'item_store.item_id')
            ->where('selling_flag', 1)
            ->where('item_store.store_id', $sid)
            ->orderby('colors.color_list','asc')
            ->orderby('size_name','asc')
            // ->select('id', 'company_id', 'barcode', 'product_code', 'size_name','color_list','color_code','stock_amount','stock_set')
            ->get();
            // dd($valiations);
        } else {
            $valiations = null;
        }

        $img_list = [];
        if ($item->item_img1) {
            $img_list[] = $item->item_img1;
        }
        if ($item->item_img2) {
            $img_list[] = $item->item_img2;
        }
        if ($item->item_img3) {
            $img_list[] = $item->item_img3;
        }
        if ($item->item_img4) {
            $img_list[] = $item->item_img4;
        }
        if ($item->item_img5) {
            $img_list[] = $item->item_img5;
        }
        if ($item->item_img6) {
            $img_list[] = $item->item_img6;
        }
        if ($item->item_img7) {
            $img_list[] = $item->item_img7;
        }
        if ($item->item_img8) {
            $img_list[] = $item->item_img8;
        }
        if ($item->item_img9) {
            $img_list[] = $item->item_img9;
        }
        if ($item->item_img10) {
            $img_list[] = $item->item_img10;
        }

        // カテゴリリスト取得
        $lists = ItemStore::where('store_id', $store_id)->where('selling_flag', 1)->select('id', 'item_id')->get();

        $cateLists = [];
        // 商品リストから、カテゴリIDを配列に変換
        foreach ($lists as $list) {
            $cateLists[] = $list->item->category_id;
        }
        // カテゴリIDからカテゴリ名を抽出
        $catelist = Category::whereIn('id', $cateLists)->where('display_flag', 1)->select('id', 'category_name')->get();

        $location = Store::where('id',$store_id)->selectRaw('ST_X( location ) As latitude, ST_Y( location ) As longitude')->first();

        $lat = $location->latitude;
        $lng = $location->longitude;

        // dd($location, $lat, $lng);

        // 価格設定
        $price = pricesSet($item);

        // 類似商品探す
        // $item = Item::where('product_code', $item_code)->orWhere('barcode', $item->barcode)->where('item_status', 1)->get();
        // dd($price);
        $itemLists = DB::table('item_store')
        ->leftJoin('stores', 'item_store.store_id', '=', 'stores.id')
        ->leftJoin('items', 'item_store.item_id', '=', 'items.id')
        ->where('product_code', $item_code)
        ->orWhere('barcode', $item->barcode)
        ->where('item_status', 1)
        ->where('display_flag', 1)
        ->where('selling_flag', 1)
        ->where('pause_flag', 1)
        ->selectRaw("store_id,item_id,price_type,price,value,start_date,end_date,stock_amount,stock_set,shelf_number,stores.company_id,barcode,product_code,product_name,original_price,item_img1,store_code,store_name,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT( 'LineString( " . $lat . " " . $lng . " , ', ST_X( location ) ,  ' ', ST_Y( location ) ,  ')' ))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
        // ->selectRaw("id,store_id,item_id,price_type,price,value,start_date,end_date,stock_amount,stock_set,company_id,barcode,product_code,product_name,original_price,item_img1,store_code,store_name,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT( 'LineString( " . $lat . " " . $lng . " , ', ST_X( location ) ,  ' ', ST_Y( location ) ,  ')' ))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
        ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
        ->orderBy('distance', 'ASC') //遠い順、近い順
        ->limit(200)
        ->get();

        // $itemList = [];
        foreach($itemLists as $iList){
            $priceSet = pricesSet($iList);
            $iVal = collect($iList);
            $iVal->put('price_set', $priceSet);
            $item_lists[] = $iVal;
            // dd($itemList);
            
            // $itemList->push($iList);
            // if (isset($itemList->start_date) and isset($itemList->end_date)) {
            //     $start_date = new Carbon($itemList->start_date); // セール開始時刻を取得
            //     $end_date = new Carbon($itemList->end_date); // セール終了時刻を取得
            //   } else {
            //     // startdate 代入するとき外に出す必要ある…
            //     $start_date = NULL;
            //     $end_date = NULL;
            //   }
            
            //   $now = Carbon::now(); // 現在時刻を取得
              
            //   if (Carbon::parse($now)->between($start_date, $end_date) and isset($itemList->value)) {
            //     // 開始時刻と終了時刻の間に現在時刻があり、セール価格に登録がある場合
            //     $price_num = number_format($itemList->value); //３桁区切り
            //     switch ($itemList->price_type) {
            //         // セール価格を出力
            //       case '0':
            //         $price = 'SALE:<span class="price">' . $price_num . '</span>円';
            //         break;
            //       case '1':
            //         $price = 'SALE:～<span class="price">' . $price_num . '</span>円';
            //         break;
            //       case '2':
            //         $price = 'SALE:<span class="price">' . $price_num . '</span>円～';
            //         break;
            //     }
            //   } else {
            //     //　それ以外の場合
            //     if (isset($itemList->price)) {
            //       // 通常価格が設定されている場合
            //       $price_num = number_format($itemList->price); //３桁区切り
            //       switch ($itemList->price_type) {
            //         case '0':
            //           $price = '価格:<span class="price">' . $price_num . '</span>円';
            //           break;
            //         case '1':
            //           $price = '価格:～<span class="price">' . $price_num . '</span>円';
            //           break;
            //         case '2':
            //           $price = '価格:<span class="price">' . $price_num . '</span>円～';
            //           break;
            //       }
            //     } elseif (isset($itemList->item->original_price)) {
            //       //　通常価格に設定がない場合、定価を出力
            //       $price_num = number_format($itemList->item->original_price); //３桁区切り
            //       $price = '定価:<span class="price">' . $price_num . '</span>円';
            //     } else {
            //       // 定価の設定も空欄の場合
            //       $price = 'オープン価格';
            //     }
            //   }
        }
        // dd($item_lists);

        // dd($price);
        return view('item', compact('item', 'store_info', 'sku', 'valiations', 'img_list', 'catelist', 'location', 'price','item_lists'));
    }
}
