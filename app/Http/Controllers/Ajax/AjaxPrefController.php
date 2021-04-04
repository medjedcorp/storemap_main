<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
// use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\StoremapCategory;
use App\Models\Store;
use App\Models\Item;
use App\Models\ItemStore;
use DB;
use Carbon\Carbon;

class AjaxPrefController extends Controller
{
  public function index(Request $request)
  {
    // キーワードと現在地とSMカテゴリを取得
    $keyword = $request->input('keyword');
    $lat =  $request->input('lat');
    $lng =  $request->input('lng');
    // $smid = $request->input('smid');

    // if (isset($smid)) {
    //   $smids = StoremapCategory::orWhereDescendantOf($smid)->pluck('id');
    //   $low_cates = StoremapCategory::where('parent_id', $smid)->get();
    // } else {
    //   $smids = StoremapCategory::pluck('id');
    //   $low_cates = StoremapCategory::where('parent_id', null)->get();
    // }
    // dd($request);
    // 近くのお店100件を取得
    $stores = Store::ActiveStore()
      // ->with('item_store.item')
      ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT( 'LineString( " . $lat . " " . $lng . " , ', ST_X( location ) ,  ' ', ST_Y( location ) ,  ')' ))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
      ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
      ->orderBy('distance', 'ASC') //遠い順、近い順
      ->limit(100)
      ->get();

    $store_items = [];
    // キーワードに一致する商品があるか検索。
    // 合致する中でsort_numの値が高い商品情報を取得
    foreach ($stores as $store) {

      $items = ItemStore::where('store_id', $store->id)->ItemSort()->with('item')
        // ->whereIn('item_store.item_id', function ($query) use ($keyword, $smids) {
        ->whereIn('item_store.item_id', function ($query) use ($keyword) {
          $query->from('items')
            ->select('items.id')
            // ->whereIn('items.storemap_category_id', $smids)
            ->where(function ($query) use ($keyword) {
              $query->orWhere('items.product_code', 'like', '%' . $keyword . '%')
                ->orWhere('items.product_name', 'like', '%' . $keyword . '%')
                ->orWhere('items.barcode', 'like', '%' . $keyword . '%')
                ->orWhere('items.tag', 'like', '%' . $keyword . '%');
            });
        })->first();
        // dd($keyword,$items,$smids);
      // お店内の合致する商品の個数をカウント
      $count_item = ItemStore::where('store_id', $store->id)->ItemSort()->with('item')
        // ->whereIn('item_store.item_id', function ($query) use ($keyword, $smids) {
        ->whereIn('item_store.item_id', function ($query) use ($keyword) {
          $query->from('items')
            ->select('items.id')
            // ->whereIn('items.storemap_category_id', $smids)
            ->where(function ($query) use ($keyword) {
              $query->orWhere('items.product_code', 'like', '%' . $keyword . '%')
                ->orWhere('items.product_name', 'like', '%' . $keyword . '%')
                ->orWhere('items.barcode', 'like', '%' . $keyword . '%')
                ->orWhere('items.tag', 'like', '%' . $keyword . '%');
            });
        })->count();

      // if ($store->distance > 1000) {
      //   //距離が1km以上と以下で単位変換
      //   $distance = round($store->distance / 1000, 2) . 'km';
      // } else {
      //   $distance = $store->distance . 'm';
      // }

      if (isset($items->start_date) and isset($items->end_date)) {
        $start_date = new Carbon($items->start_date); // セール開始時刻を取得
        $end_date = new Carbon($items->end_date); // セール終了時刻を取得
      } else {
        $start_date = NULL;
        $end_date = NULL;
      }

      $now = Carbon::now(); // 現在時刻を取得

      if (Carbon::parse($now)->between($start_date, $end_date) and isset($items->value)) {
        // 開始時刻と終了時刻の間に現在時刻があり、セール価格に登録がある場合
        $price_num = number_format($items->value); //３桁区切り
        switch ($items->price_type) {
            // セール価格を出力
          case '0':
            $price = 'SALE:<span class="price">' . $price_num . '</span>円';
            break;
          case '1':
            $price = 'SALE:～<span class="price">' . $price_num . '</span>円';
            break;
          case '2':
            $price = 'SALE:<span class="price">' . $price_num . '</span>円～';
            break;
        }
      } else {
        //　それ以外の場合
        if (isset($items->price)) {
          // 通常価格が設定されている場合
          $price_num = number_format($items->price); //３桁区切り
          switch ($items->price_type) {
            case '0':
              $price = '価格:<span class="price">' . $price_num . '</span>円';
              break;
            case '1':
              $price = '価格:～<span class="price">' . $price_num . '</span>円';
              break;
            case '2':
              $price = '価格:<span class="price">' . $price_num . '</span>円～';
              break;
          }
        } elseif (isset($items->item->original_price)) {
          //　通常価格に設定がない場合、定価を出力
          $price_num = number_format($items->item->original_price); //３桁区切り
          $price = '定価:<span class="price">' . $price_num . '</span>円';
        } else {
          // 定価の設定も空欄の場合
          $price = 'オープン価格';
        }
      }

      if($items){
        // items がnullじゃない場合
        if($items->stock_set === 0){
          $stocks = '在庫：要問合せ';
        } elseif ($items->stock_amount > 10 and $items->stock_set === 1) {
          $stocks = '在庫：◎';
        } elseif ($items->stock_amount > 0 and $items->stock_amount <= 5 and $items->stock_set === 1) {
          $stocks = '在庫：△';
        } elseif ($items->stock_amount <= 0 and $items->stock_set === 1) {
          $stocks = '在庫：なし';
        } else {
          $stocks = '在庫：要問合せ';
        } 
      } else {
        // items がnull の場合
          $stocks = null;
      }
      // dd($price_num);
      
      if ($count_item > 0) {
        $store_items[] = array(
          'id' => $store->id,
          'store_name' => $store->store_name,
          'store_info' => $store->store_info,
          'store_postcode' => $store->store_postcode,
          'store_address' => $store->prefecture . $store->store_city . $store->store_adnum . $store->store_apart,
          'store_phone_number' => $store->store_phone_number,
          'store_email' => $store->store_email,
          // 'distance' => $distance,
          'product_code' => $items->item->product_code,
          'product_name' => $items->item->product_name,
          'count' => $count_item,
          'store_img1' => $store->store_img1,
          'item_img1' => $items->item->item_img1,
          'company_id' => $items->item->company_id,
          'price' => $price,
          'shelf_number' => $items->shelf_number,
          'longitude' => $store->longitude,
          'latitude' => $store->latitude,
          'updated_at' => $items->updated_at,
          'keyword' => $keyword,
          // 'smid' => $smid,
          'stocks' => $stocks,
        );
      }
    }

    $store_items = json_encode($store_items, JSON_UNESCAPED_UNICODE); // 日本語化
    // dd($count_item, $store_items);
    // return $keyword;
    return $store_items;
  }
}
