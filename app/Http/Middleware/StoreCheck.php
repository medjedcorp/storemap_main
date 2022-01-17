<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use Closure;

class StoreCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // お店登録が0の場合は、お店登録に飛ばす。
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user->role === "admin") {
            return $next($request);
        } else {
            $stores = Store::where('company_id', $user->company_id)->count();
            if ($stores === 0) {
                return redirect(route('stores.create'))->with('warning', '※最初に商品の取り扱い店舗を作成してください');
            } else {
                return $next($request);
            }
        }
    }
}
