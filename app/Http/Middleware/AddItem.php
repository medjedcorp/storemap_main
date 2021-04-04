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
    // お店登録のときに、契約店舗数以上ならindexに飛ばす
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
        $light_item = config('services.stripe.light_item');
        $basic_item = config('services.stripe.basic_item');
        $premium_item = config('services.stripe.premium_item');
        // ストア数プラン以外で、引っかかるプランを取得(店舗数)
        $subscriptionItem = $company->subscription('main')->items->whereNotIn('stripe_plan', $stores)->first();
        // プラン名を取得
        $stripePlan = $subscriptionItem->stripe_plan;

        switch($stripePlan){
            case $light:
              $max_item = $light_item;
              break;
            case $basic:
              $max_item = $basic_item;
              break;
            case $premium:
              $max_item = $premium_item;
              break;
            default:
              $max_item = 0;
          }

        // 現在の店舗数を取得
        $now_item_count = Item::where('company_id', $user->company_id)->count();

        if ($now_item_count >= $max_item) {
            return redirect("/items")->with('danger', '※登録可能商品点数の上限に達しています。登録される場合は、お支払い設定よりプランを変更するか、商品を削除してください');
        }
        // dd($now_store_count , $quantity);
        return $next($request);
    }
}
