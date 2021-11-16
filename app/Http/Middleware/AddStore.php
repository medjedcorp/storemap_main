<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Models\Company;
use Laravel\Cashier\Cashier;
use Closure;

class AddStore
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

        // // freeプランの場合
        // if ($user->role == 'free') {
        //     $now_store_count = Store::where('company_id', $user->company_id)->count();
        //     $freeStore = config('services.stripe.free_store');
        //     if ($now_store_count > $freeStore) {
        //         // 2以上なら、リダイレクトしてエラー
        //         return redirect("/stores")->with('danger', '※登録可能店舗数の上限に達しています。登録される場合は、お支払い設定より店舗数を増やすか、店舗を削除してください');
        //     } else {
        //         return $next($request);
        //     }
        // }

        // 現在の店舗数を取得
        $now_store_count = Store::where('company_id', $user->company_id)->count();
        // dd($now_store_count);
        // ストア数のプランをconfigより取得
        $stores = config('services.stripe.stores');

        // 有効な課金があるかチェック
        if ($company->subscribed('main')) {
            // ストア数のプランを取得
            $storesItem = $company->subscription('main')->items->where('stripe_plan', $stores)->first();
            $quantity = $storesItem->quantity;
            // 取得した値に1プラスしたのが登録可能店舗数
            $quantity = $quantity + 1;
        } else {
            // ない場合は 1
            $quantity = 1;
        }

        if ($now_store_count >= $quantity) {
            return redirect("/stores")->with('danger', '※登録可能店舗数の上限に達しています。登録される場合は、お支払い設定より店舗数を増やすか、店舗を削除してください');
        }
        // dd($now_store_count , $quantity);
        return $next($request);
    }
}
