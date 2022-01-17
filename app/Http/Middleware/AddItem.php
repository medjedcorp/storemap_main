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

    if ($user->role === "admin") {
      return $next($request);
    } else {
      // 自作関数productCountを呼び出し。上限チェック
      $resultItem = productCount($user);
      if (!$resultItem) {
        return redirect("/items")->with('danger', '※登録可能商品点数の上限に達しています。登録される場合は、お支払い設定よりプランを変更するか、商品を削除してください');
      } else {
        return $next($request);
      }
    }
  }
}
