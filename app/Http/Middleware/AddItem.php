<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
// use App\Models\Item;
// use App\Models\Company;
// use Laravel\Cashier\Cashier;
use Closure;
// use Carbon\Carbon;

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
    // $company = Company::where('id', $user->company_id)->first();

    // 自作関数productCountを呼び出し。上限チェック
    $resultItem = productCount($user);

    // 現在の商品数を取得
    // $now_item_count = Item::where('company_id', $user->company_id)->count();

    // // 登録後１年以内かを判定するための準備
    // $nowDateTime = new Carbon();
    // $createDateTime = new Carbon($company->created_at);
    // $maxDateTime = $createDateTime->addYears(1);

    // // プランを取得
    // $stores = config('services.stripe.stores');
    // $light = config('services.stripe.light');
    // $basic = config('services.stripe.basic');
    // $premium = config('services.stripe.premium');
    // // 登録可能商品点数を取得
    // $lightItem = config('services.stripe.light_item');
    // $basicItem = config('services.stripe.basic_item');
    // $premiumItem = config('services.stripe.premium_item');
    // $freeItem = config('services.stripe.free_item');

    // // 有効な課金があるかチェック
    // if ($company->subscribed('main')) {
    //   // ある場合はプラン名を代入
    //   $subscriptionItem = $company->subscription('main')->items->whereNotIn('stripe_plan', $stores)->first();
    //   $stripePlan = $subscriptionItem->stripe_plan;
    // } else {
    //   $stripePlan = null;
    // }

    // switch ($stripePlan) {
    //   case $light:
    //     // $max_item = $lightItem;
    //     // 会社登録後１年以内ならベーシックまで同数登録可能
    //     if ($nowDateTime > $maxDateTime) {
    //       $max_item = $lightItem;
    //     } else {
    //       $max_item = $basicItem;
    //     }
    //     break;
    //   case $basic:
    //     $max_item = $basicItem;
    //     break;
    //   case $premium:
    //     $max_item = $premiumItem;
    //     break;
    //   default:
    //     // $max_item = $freeItem;
    //     // 会社登録後１年以内ならベーシックまで同数登録可能
    //     if ($nowDateTime > $maxDateTime) {
    //       $max_item = $freeItem;
    //     } else {
    //       $max_item = $basicItem;
    //     }
    // }

    if (!$resultItem) {
      // dd($result);
      return redirect("/items")->with('danger', '※登録可能商品点数の上限に達しています。登録される場合は、お支払い設定よりプランを変更するか、商品を削除してください');
    } else {
      return $next($request);
    }

    // dd($now_item_count, $max_item);
    // if ($now_item_count >= $max_item) {
    //   return redirect("/items")->with('danger', '※登録可能商品点数の上限に達しています。登録される場合は、お支払い設定よりプランを変更するか、商品を削除してください');
    // }
    // // dd($now_store_count , $quantity);
    // return $next($request);
  }
}
