<?php

use Carbon\Carbon;

// 自作関数 composer.jsonで読み込み
function storeItemSet($store_data){

    $store_items = array();
    
    foreach($store_data as $store){

      // セール時刻がセットされているか確認
      if(isset($store->start_date) and isset($store->end_date)){
        $start_date = new Carbon($store->start_date); // セール開始時刻を取得
        $end_date = new Carbon($store->end_date); // セール終了時刻を取得
      } else {
        $start_date = NULL;
        $end_date = NULL;
      }

      // 価格設定
      $price = pricesSet($store);

      // 在庫設定
      $stocks = stocksSet($store);


      // // セール時刻がセットされているか確認
      // if(isset($store->start_date) and isset($store->end_date)){
      //   $start_date = new Carbon($store->start_date); // セール開始時刻を取得
      //   $end_date = new Carbon($store->end_date); // セール終了時刻を取得
      // } else {
      //   $start_date = NULL;
      //   $end_date = NULL;
      // }

      // $now = Carbon::now(); // 現在時刻を取得

      // if (Carbon::parse($now)->between($start_date, $end_date) and isset($store->value)) {
      //   // 開始時刻と終了時刻の間に現在時刻があり、セール価格に登録がある場合
      //   $price_num = number_format($store->value); //３桁区切り
      //   switch($store->price_type){
      //     // セール価格を出力
      //     case '0':
      //       $price = 'SALE:<span class="price">'. $price_num .'</span>円';
      //       break;
      //     case '1':
      //       $price = 'SALE:～<span class="price">'. $price_num .'</span>円';
      //       break;
      //     case '2':
      //       $price = 'SALE:<span class="price">'. $price_num .'</span>円～';
      //       break;
      //   }
      // } else {
      //   //　それ以外の場合
      //   if(isset($store->price)){
      //     // 通常価格が設定されている場合
      //     $price_num = number_format($store->price); //３桁区切り
      //     switch($store->price_type){
      //       case '0':
      //         $price = '価格:<span class="price">'. $price_num .'</span>円';
      //         break;
      //       case '1':
      //         $price = '価格:～<span class="price">'. $price_num .'</span>円';
      //         break;
      //       case '2':
      //         $price = '価格:<span class="price">'. $price_num .'</span>円～';
      //         break;
      //     }
      //   } elseif(isset($store->item->original_price)) {
      //     //　通常価格に設定がない場合、定価を出力
      //     $price_num = number_format($store->item->original_price); //３桁区切り
      //     $price = '定価:<span class="price">' . $price_num . '</span>円';
      //   } else {
      //     // 定価の設定も空欄の場合
      //     $price = 'オープン価格';
      //   }
      // }

      // 在庫情報設定。在庫０個で在庫設定する場合は、在庫なしを表示
      // if ($store->stock_amount < 1 and $store->stock_set === 1) {
      //   $stock = '在庫なし';
      // } else {
      //   $stock = null;
      // }

      $store_items[] = array(
        'id' => $store->item->id,
        'store_id' => $store->store_id,
        'product_code' => $store->item->product_code,
        'product_name' => $store->item->product_name,
        'catch_copy' => $store->catch_copy,
        'item_img1' => $store->item->item_img1,
        'price' => $price, 
        'shelf_number' => $store->shelf_number,
        'updated_at' => $store->updated_at,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'stocks' => $stocks
      );
    }

    return $store_items;
  }