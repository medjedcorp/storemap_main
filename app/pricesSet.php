<?php

use Carbon\Carbon;

// 自作関数 composer.jsonで読み込み
function pricesSet($items)
{
  
  if (isset($items->start_date) and isset($items->end_date)) {
    $start_date = new Carbon($items->start_date); // セール開始時刻を取得
    $end_date = new Carbon($items->end_date); // セール終了時刻を取得
  } else {
    // startdate 代入するとき外に出す必要ある…
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
          $price = '<span class="price">' . $price_num . '</span>円';
          break;
        case '1':
          $price = '～<span class="price">' . $price_num . '</span>円';
          break;
        case '2':
          $price = '<span class="price">' . $price_num . '</span>円～';
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

  return $price;
}
