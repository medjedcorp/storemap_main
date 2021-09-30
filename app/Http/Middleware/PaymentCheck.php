<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use Closure;

class PaymentCheck
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  // 最初にcompany_idが登録されていない場合は、登録ページに飛ばす処理
  public function handle($request, Closure $next)
  {
    $user = Auth::user();
    // $company = Company::where('id', $user->company_id)->first();

    if ($user->role === 'seller' && empty($user->company_id))  {
      return redirect(route('company.create'))->with('warning', '※最初に会社情報を登録してください');
    }

    return $next($request);
  }
}
