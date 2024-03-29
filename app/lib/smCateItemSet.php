<?php

use App\Models\ItemStore;

// 自作関数 composer.jsonで読み込み
function smCateItemSet($store_data, $smids){

  // storemapカテゴリに値がある場合の処理

    $store_items = [];
    
    foreach ($store_data as $store) {
      // キーワードある場合
      $items = ItemStore::where('store_id', $store->id)->ActiveStock()->ItemSort()->with('item')
      ->whereIn('item_store.item_id', function ($query) use ($smids) {
        $query->from('items')
          ->select('items.id')
          ->whereIn('items.storemap_category_id', $smids);
      })
      ->first();

      // 件数もカウント

      $count_item = ItemStore::where('store_id', $store->id)->ActiveStock()->ItemSort()->with('item')
      ->whereIn('item_store.item_id', function ($query) use ($smids) {
        $query->from('items')
          ->select('items.id')
          ->whereIn('items.storemap_category_id', $smids);
      })
      ->count();

      // 距離変換処理
      $distance = distanceSet($store);

      // 価格設定
      $price = pricesSet($items);

      // 在庫設定
      $stocks = stocksSet($items);

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
          'keyword' => null,
          'stocks' => $stocks,
        );
      }
    }

    return $store_items;
  }