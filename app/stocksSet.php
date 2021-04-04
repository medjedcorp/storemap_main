<?php

// 自作関数 composer.jsonで読み込み
function stocksSet($items)
{
  if ($items) {
    // items がnullじゃない場合
    if ($items->stock_set === 0) {
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
    $stocks = null;
  }

  return $stocks;
}
