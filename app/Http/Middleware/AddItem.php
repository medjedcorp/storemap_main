<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Company;
use Laravel\Cashier\Cashier;
use Closure;

class AddItem
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  // 商品登録のときに、契約店舗数以上ならindexに飛ばす
  public function handle($request, Closure $next)
  {
    $user = Auth::user();
    $company = Company::where('id', $user->company_id)->first();

    // プランを取得
    $stores = config('services.stripe.stores');
    $light = config('services.stripe.light');
    $basic = config('services.stripe.basic');
    $premium = config('services.stripe.premium');
    // 登録可能商品点数を取得
    $lightItem = config('services.stripe.light_item');
    $basicItem = config('services.stripe.basic_item');
    $premiumItem = config('services.stripe.premium_item');
    $freeItem = config('services.stripe.free_item');

    // 有効な課金があるかチェック
    if ($company->subscribed('main')) {
      // ある場合はプラン名を代入
      $subscriptionItem = $company->subscription('main')->items->whereNotIn('stripe_plan', $stores)->first();
      $stripePlan = $subscriptionItem->stripe_plan;
    } else {
      $stripePlan = null;
    }

    switch ($stripePlan) {
      case $light:
        $max_item = $lightItem;
        break;
      case $basic:
        $max_item = $basicItem;
        break;
      case $premium:
        $max_item = $premiumItem;
        break;
      default:
        $max_item = $freeItem;
    }

    // 現在の商品数を取得
    $now_item_count = Item::where('company_id', $user->company_id)->count();

    if ($now_item_count >= $max_item) {
      return redirect("/items")->with('danger', '※登録可能商品点数の上限に達しています。登録される場合は、お支払い設定よりプランを変更するか、商品を削除してください');
    }
    // dd($now_store_count , $quantity);
    return $next($request);
  }
}
