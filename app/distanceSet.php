<?php

// 自作関数 composer.jsonで読み込み
function distanceSet($store)
{

  if ($store->distance > 1000) {
    //距離が1km以上と以下で単位変換
    $distance = round($store->distance / 1000, 2) . 'km';
  } else {
    $distance = $store->distance . 'm';
  }

  return $distance;
}
