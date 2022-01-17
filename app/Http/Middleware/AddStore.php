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
        if ($user->role === "admin") {
            return $next($request);
        } elseif ($user->role === "new") {
            return $next($request);
        } else {
            $company = Company::where('id', $user->company_id)->first();
            // 現在の公開中店舗数を取得
            $now_store_count = Store::where('company_id', $user->company_id)->where('pause_flag', 1)->count();
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
            if ($now_store_count === $quantity) {
                return redirect('/stores')->with('danger', '※登録可能店舗数の上限に達しました。お支払い設定より店舗数を増やすか、店舗を削除してください');
            } elseif ($now_store_count > $quantity) {
                
                // dd($now_store_count, $quantity);
                // $getStores = Store::where('company_id', $user->company_id)->get();
                $getStores = Store::where('company_id', $user->company_id)->where('pause_flag', 1)->get();
                $counter = $now_store_count - $quantity; // 4 - 3 = 1
                $count = 0;

                foreach ($getStores as $getStore) {
                    $getStore->pause_flag = 0;
                    $getStore->save();
                    $count++;
                    
                    if ($count == $counter) {
                        break;
                    }
                }
                // dd($count);
                // return $next($request);
                // return redirect()->action('StoreController@index');with('danger', '※登録可能店舗数の上限に達したため、一部店舗を非公開設定に変更しました。お支払い設定より店舗数を増やすか、店舗を削除してください');
                // return redirect()->route('stores.index')->with('danger', '※登録可能店舗数の上限に達したため、一部店舗を非公開設定に変更しました。お支払い設定より店舗数を増やすか、店舗を削除してください');
                // return redirect('/stores')->with('danger', '※登録可能店舗数の上限に達したため、一部店舗を非公開設定に変更しました。お支払い設定より店舗数を増やすか、店舗を削除してください');
                // return back()->with('danger', '※登録可能店舗数の上限に達したため、一部店舗を非公開設定に変更しました。お支払い設定より店舗数を増やすか、店舗を削除してください');
                return redirect('/stores')->with('danger', '※登録可能店舗数の上限に達したため、一部店舗を非公開設定に変更しました。お支払い設定より店舗数を増やすか、店舗を削除してください');
                // return redirect('/stores/');
            }
            // dd($now_store_count , $quantity);
            return $next($request);
        }
    }
}
