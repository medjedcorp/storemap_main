<?php

use App\Models\Company;
use Laravel\Cashier\Cashier;
use Carbon\Carbon;

// 自作関数 composer.jsonで読み込み
// 商品登録の時に、登録可能商品数を上回っていないかチェック
function maxImgCap($user)
{
  // ジョブに渡すためのユーザ情報
  $cid  = $user->company_id;

  $company = Company::where('id', $cid)->first();
  // プランを取得
  $stores = config('services.stripe.stores');
  $light = config('services.stripe.light');
  $basic = config('services.stripe.basic');
  $premium = config('services.stripe.premium');
  // MAXのストレージ容量を取得
  $light_storage = config('services.stripe.light_storage');
  $basic_storage = config('services.stripe.basic_storage');
  $premium_storage = config('services.stripe.premium_storage');
  $free_storage = config('services.stripe.free_storage');

  // 登録後１年以内かを判定するための準備
  $newCusDay = config('services.newCustomerDays');
  $nowDateTime = new Carbon(); // 現在の日付
  $createDateTime = new Carbon($company->created_at); // 登録日
  $maxDateTime = $createDateTime->addDays($newCusDay); // 登録から１年後の日付

  // 有効な課金があるかチェック
  if ($company->subscribed('main')) {
    // 有効な課金がある場合は、プランを代入
    $subscriptionItem = $company->subscription('main')->items->whereNotIn('stripe_plan', $stores)->first();
    $stripePlan = $subscriptionItem->stripe_plan;
  } else {
    // ない場合はnull
    $stripePlan = null;
  }

  // ストレージ容量を設定
  switch ($stripePlan) {
    case $light:
      // $max_size = $light_storage;
      if ($nowDateTime > $maxDateTime) {
        $max_size = $light_storage;
      } else {
        $max_size = $basic_storage;
      }
      break;
    case $basic:
      $max_size = $basic_storage;
      break;
    case $premium:
      $max_size = $premium_storage;
      break;
    default:
      // $max_size = $free_storage;
      if ($nowDateTime > $maxDateTime) {
        $max_size = $free_storage;
      } else {
        $max_size = $basic_storage;
      }
  }

  // 最大容量をリターン
  return $max_size;
}
