<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Item;
use App\Models\ItemStore;
use App\Models\StoremapCategory;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;

// https://github.com/lazychaser/laravel-nestedsetを使ってます

class SmCateShowController extends Controller
{
  public function show(Request $request)
  {
    // IDをurlから取得
    $smid = $request->id;
    $keyword = $request->keyword;
    $lat =  $request->input('lat');
    $lng =  $request->input('lng');

    if(isset($smid)){
      $smids = StoremapCategory::orWhereDescendantOf($smid)->pluck('id');
          // IDから下位カテゴリを抽出
      $low_cates = StoremapCategory::where('parent_id', $smid)->get();
      $sm_name =  StoremapCategory::where('id', $smid)->first();
    } else {
      // トップから検索できた場合
      $smids = StoremapCategory::pluck('id');
      $low_cates = StoremapCategory::where('parent_id', null)->get();
      $sm_name = null;
    }
    // 近所のお店200件を取得
    $stores = Store::ActiveStore()
    ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT( 'LineString( " . $lat . " " . $lng . " , ', ST_X( location ) ,  ' ', ST_Y( location ) ,  ')' ))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
    ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
    ->orderBy('distance', 'ASC') //遠い順、近い順
    ->limit(200)
    ->get();

    $store_items = array();
    // キーワードに一致する商品があるか検索。
    // 合致する中でsort_numの値が高い商品情報を取得
    foreach ($stores as $store) {
      if(isset($keyword) && isset($smid)){
        // キーワードあって、SMカテゴリもある場合
        // $items = ItemStore::where('store_id', $store->id)->ItemSort()->with('item')
        // ->whereIn('item_store.item_id', function ($query) use ($keyword, $smids) {
        //   $query->from('items')
        //     ->select('items.id')
        //     ->whereIn('items.storemap_category_id', $smids)
        //     ->orWhere('items.product_code', 'like', '%' . $keyword . '%')
        //     ->orWhere('items.product_name', 'like', '%' . $keyword . '%')
        //     ->orWhere('items.barcode', 'like', '%' . $keyword . '%')
        //     ->orWhere('items.tag', 'like', '%' . $keyword . '%');
        // })
        // ->first();
        $items = ItemStore::where('store_id', $store->id)->ItemSort()->with('item')
        ->whereIn('item_store.item_id', function ($query) use ($keyword, $smids) {
          $query->from('items')
            ->select('items.id')
            ->whereIn('items.storemap_category_id', $smids)
            ->where(function($query) use($keyword){
              $query->orWhere('items.product_code', 'like', '%' . $keyword . '%')
                    ->orWhere('items.product_name', 'like', '%' . $keyword . '%')
                    ->orWhere('items.barcode', 'like', '%' . $keyword . '%')
                    ->orWhere('items.tag', 'like', '%' . $keyword . '%');
            });
        })->first();
        // dd($items);
      } elseif(isset($keyword) && empty($smid)) {
        // キーワードあって、SMカテゴリが空の場合
        $items = ItemStore::where('store_id', $store->id)->ItemSort()->with('item')
        ->whereIn('item_store.item_id', function ($query) use ($keyword) {
          $query->from('items')
            ->select('items.id')
            ->orWhere('items.product_code', 'like', '%' . $keyword . '%')
            ->orWhere('items.product_name', 'like', '%' . $keyword . '%')
            ->orWhere('items.barcode', 'like', '%' . $keyword . '%')
            ->orWhere('items.tag', 'like', '%' . $keyword . '%');
        })
        ->first();
        // $items = ItemStore::where('store_id', $store->id)->ItemSort()->with('item')
        // ->whereIn('item_store.item_id', function ($query) use ($keyword) {
        //   $query->from('items')
        //     ->select('items.id')
        //     ->where('items.product_name', 'like', '%' . $keyword . '%');
        // })->first();
        // $itemtest = ItemStore::where('store_id', $store->id)->ItemSort()->with('item')->get();
        // $itemtest2 = ItemStore::where('store_id', $store->id)->ItemSort()->get();
        // dd($items,$keyword,$smid,$store->id,$itemtest,$itemtest2);
        // dd($items);
       } elseif(empty($keyword) && isset($smid)){
        // キーワードが空で、SMカテゴリの値だけある場合
        $items = ItemStore::where('store_id', $store->id)->ItemSort()->with('item')
        ->whereIn('item_store.item_id', function ($query) use ($smids) {
          $query->from('items')
            ->select('items.id')
            ->whereIn('items.storemap_category_id', $smids);
        })
        ->first();
      } else {
        // キーワードもSMカテゴリも空の場合
        $items = ItemStore::where('store_id', $store->id)->ItemSort()->with('item')->first();
      }
      // お店内の合致する商品の個数をカウント
      // $count_item = ItemStore::where('store_id', $store->id)->ItemSort()->with('item')
      // ->whereIn('item_store.item_id', function ($query) use ($smids) {
      //   $query->from('items')
      //     ->select('items.id')
      //     ->whereIn('items.storemap_category_id', $smids);
      // })->count();
      // $count_item = ItemStore::where('store_id', $store->id)->ItemSort()->with('item')
      //   ->whereIn('item_store.item_id', function ($query) use ($keyword, $smids) {
      //     $query->from('items')
      //       ->select('items.id')
      //       ->whereIn('items.storemap_category_id', $smids)
      //       ->orWhere('items.product_code', 'like', '%' . $keyword . '%')
      //       ->orWhere('items.product_name', 'like', '%' . $keyword . '%')
      //       ->orWhere('items.barcode', 'like', '%' . $keyword . '%')
      //       ->orWhere('items.tag', 'like', '%' . $keyword . '%');
      //   })
      //   ->count();

      $count_item = ItemStore::where('store_id', $store->id)->ItemSort()->with('item')
      ->whereIn('item_store.item_id', function ($query) use ($keyword, $smids) {
        $query->from('items')
          ->select('items.id')
          ->whereIn('items.storemap_category_id', $smids)
          ->where(function($query) use($keyword){
            $query->orWhere('items.product_code', 'like', '%' . $keyword . '%')
                  ->orWhere('items.product_name', 'like', '%' . $keyword . '%')
                  ->orWhere('items.barcode', 'like', '%' . $keyword . '%')
                  ->orWhere('items.tag', 'like', '%' . $keyword . '%');
          });
      })->count();



      if ($store->distance > 1000) {
        //距離が1km以上と以下で単位変換
        $distance = round($store->distance / 1000, 2) . 'km';
      } else {
        $distance = $store->distance . 'm';
      }

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
          'distance' => $distance,
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
        );
      }
    }
    $store_items = collect($store_items); // 配列をコレクションに変換

    // dd($low_cates);
    // dd($items,$count_item);
    // dd($items,$count_item,$count_item2 );
    return view('smcate.index', compact('store_items','low_cates','keyword', 'smid', 'lat', 'lng', 'sm_name'));
  }
}
