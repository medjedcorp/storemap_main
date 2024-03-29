<?php

use App\Models\Company;
use App\Models\Item;
use Laravel\Cashier\Cashier;
use Carbon\Carbon;

// 自作関数 composer.jsonで読み込み
// 商品登録の時に、登録可能商品数を上回っていないかチェック
function productCount($user)
{
  // ジョブに渡すためのユーザ情報
  $cid  = $user->company_id;

  // プランを取得
  $company = Company::where('id', $cid)->first();
  $stores = config('services.stripe.stores');
  $light = config('services.stripe.light');
  $basic = config('services.stripe.basic');
  $premium = config('services.stripe.premium');
  // 登録可能商品点数を取得
  $light_item = config('services.stripe.light_item');
  $basic_item = config('services.stripe.basic_item');
  $premium_item = config('services.stripe.premium_item');
  $free_item = config('services.stripe.free_item');

  // 現座のアイテム数を取得
  $itemCount = item::where('company_id', $cid)->count();

  // 登録後１年以内かを判定するための準備
  $newCusDay = config('services.newCustomerDays');
  $nowDateTime = new Carbon(); // 現在の日付
  $createDateTime = new Carbon($company->created_at); // 登録日
  $maxDateTime = $createDateTime->addDays($newCusDay); // 登録から$newCusDay後の日付

  // 有効な課金があるかチェック
  if ($company->subscribed('main')) {
    // 有効な課金がある場合は、プランを代入
    $subscriptionItem = $company->subscription('main')->items->whereNotIn('stripe_plan', $stores)->first();
    // プラン名を取得
    $stripePlan = $subscriptionItem->stripe_plan;
  } else {
    // ない場合はnull
    $stripePlan = null;
  }

  // 登録可能な商品数を設定
  switch ($stripePlan) {
    case $light:
      // $max_item = $light_item;
      if ($nowDateTime > $maxDateTime) {
        $max_item = $light_item;
      } else {
        $max_item = $basic_item;
      }
      break;
    case $basic:
      $max_item = $basic_item;
      break;
    case $premium:
      $max_item = $premium_item;
      break;
    default:
      // $max_item = $free_item;
      if ($nowDateTime > $maxDateTime) {
        $max_item = $free_item;
      } else {
        $max_item = $basic_item;
      }
  }

  // dd($itemCount, $max_item);
  if ($itemCount < $max_item) {
    $result = true;
  } else {
    $result = false;
  }

  return $result;
}
