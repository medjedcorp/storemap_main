<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use Laravel\Cashier\Cashier;
use Closure;

class CompanyCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

     // freeプランありの場合の処理
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $company = Company::where('id', $user->company_id)->first();

        if (($user->role === 'free' or $user->role === 'seller') && empty($user->company_id)) {
            return redirect(route('company.create'))->with('warning', '※ご利用前に会社情報の登録をお願いします。不明な項目は右上の「？」マークをクリックすることでヘルプを表示できます。');
        }

        return $next($request);
    }

    // 最初にcompany_idが登録されていない場合は、登録ページに飛ばす処理
    // public function handle($request, Closure $next)
    // {
    //     $user = $request->user();
    //     $company = Company::where('id', $user->company_id)->first();

    //     if ($user->role === 'seller' && empty($user->company_id)) {
    //         return redirect(route('company.create'))->with('warning', '※ご利用前に会社情報の登録をお願いします。不明な項目は右上の「？」マークをクリックすることでヘルプを表示できます。');
    //     } elseif ($company->stripe_id === null) {
    //         return redirect(route('payment.card'))->with('warning', '※不正利用防止の観点から、最初にお支払い情報の登録をお願い致します。');
    //     } elseif (!$company->subscribed('main')) {
    //         return redirect('payment/card');
    //     }

    //     if (!$company->hasDefaultPaymentMethod()) {
    //         return redirect('payment/card');
    //     }

    //     return $next($request);
    // }
}
