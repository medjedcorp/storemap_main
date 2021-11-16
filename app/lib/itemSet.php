<?php

use App\Models\ItemStore;

// 自作関数 composer.jsonで読み込み
function itemSet($store_data)
{

  $store_items = [];

  foreach ($store_data as $store) {
    // $items = ItemStore::where('store_id', $store->id)->first();
    $items = ItemStore::where('store_id', $store->id)->ActiveStock()->ItemSort()->with('item')->first();
    if (is_null($items)) {
      // nullの場合はスキップ
      continue;
    } else {
      // 件数もカウント
      $count_item = null;

      // 距離変換処理
      $distance = distanceSet($store);

      // 価格設定
      $price = pricesSet($items);

      // 在庫設定
      $stocks = stocksSet($items);

      $store_items[] = array(
        'id' => $store->id,
        'store_name' => $store->store_name,
        'store_info' => $store->store_info,
        'store_postcode' => $store->store_postcode,
        'store_address' => $store->prefecture . $store->store_city . $store->store_adnum . $store->store_apart,
        'store_phone_number' => $store->store_phone_number,
        'store_email' => $store->store_email,
        'distance' => $distance,
        // 'product_code' => $p_code,
        'product_code' => $items->item->product_code,
        // 'product_name' => $p_name,
        'product_name' => $items->item->product_name,
        'count' => $count_item,
        'store_img1' => $store->store_img1,
        'item_img1' => $items->item->item_img1,
        // 'item_img1' => $i_img1,
        'company_id' => $items->item->company_id,
        // 'company_id' => $cid,
        'price' => $price,
        'shelf_number' => $items->shelf_number,
        // 'shelf_number' => $s_num,
        'longitude' => $store->longitude,
        'latitude' => $store->latitude,
        'updated_at' => $items->updated_at,
        'keyword' => null,
        'stocks' => $stocks,
      );
    }
  }

  return $store_items;
}
