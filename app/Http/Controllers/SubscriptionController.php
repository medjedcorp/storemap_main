<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use Laravel\Cashier\Cashier;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $company = Company::where('id', $user->company_id)->first();
        $intent = $company->createSetupIntent();
        $trial_date = config('services.stripe.trial');
        $light_id = config('services.stripe.light');
        $basic_id = config('services.stripe.basic');
        $premium_id = config('services.stripe.premium');
        $stores_id = config('services.stripe.stores');
        $light_price = config('services.stripe.light_price');
        $basic_price = config('services.stripe.basic_price');
        $premium_price = config('services.stripe.premium_price');
        $add_store = config('services.stripe.add_store');

        $price_list = [
            'light' => number_format($light_price),
            'basic' => number_format($basic_price),
            'premium' => number_format($premium_price),
            'add_store' => number_format($add_store)
        ];

        // if ($company->stripe_id) {
        if ($company->subscribed('main')) {
            // 決済情報がある場合
            $payinfo = $company->subscription('main');

            if (!$company->hasDefaultPaymentMethod()) {
                // 登録はあるけど、支払い方法を持っていない場合。
                $time = new Carbon(Carbon::now());
                $trialtime = $time->addDay($trial_date);
                $trial = $trialtime->format('Y年m月d日');
                return view('payment.card', compact('company', 'intent', 'trial', 'trial_date', 'price_list'));
            }

            if ($company->subscription('main')->cancelled()) {
                // サブスクキャンセル状態の場合
                // 決済中の場合
                if ($company->subscribedToPlan($light_id, 'main')) {
                    $plan = 'ライト';
                    $laprice = 0;
                } elseif ($company->subscribedToPlan($basic_id, 'main')) {
                    $plan = 'ベーシック';
                    $laprice = 0;
                } elseif ($company->subscribedToPlan($premium_id, 'main')) {
                    $plan = 'プレミアム';
                    $laprice = 0;
                } else {
                    $plan = 'フリープラン';
                    $laprice = '0';
                }

                $store_price = 0;

                // 課金にstores_idがある場合、店舗ない場合は項目なしになる
                if ($company->subscribedToPlan($stores_id, 'main')) {
                    // stores_idの決済方法をカンパニーでセグメントしてメインから取得
                    $subscriptionItem = $company->subscription('main')->findItemOrFail($stores_id);
                    // 該当idからquantity(店舗数)を取得
                    $stores_quantity = $subscriptionItem->quantity;
                    $stores_price = $stores_quantity * 0;
                    $stores_quantity = $stores_quantity + 1;
                } else {
                    $stores_quantity = 0;
                    $stores_price = 0;
                }


                if ($company->subscription('main')->onTrial()) {
                    // 試用期間中の場合は日付を返す
                    $trial_ends = $company->subscription('main')->trial_ends_at;
                } else {
                    $trial_ends = '';
                }
                // dd($payinfo, $trial_ends, $plan, $stores_quantity);

                return view('payment.card', compact('company', 'intent', 'payinfo', 'trial_ends', 'plan', 'laprice', 'stores_quantity', 'stores_price', 'trial_date', 'price_list'));
            } else {
                // 決済中の場合
                if ($company->subscribedToPlan($light_id, 'main')) {
                    $plan = 'ライト';
                    $laprice = $light_price;
                } elseif ($company->subscribedToPlan($basic_id, 'main')) {
                    $plan = 'ベーシック';
                    $laprice = $basic_price;
                } elseif ($company->subscribedToPlan($premium_id, 'main')) {
                    $plan = 'プレミアム';
                    $laprice = $premium_price;
                } else {
                    $plan = 'フリープラン';
                    $laprice = '****';
                }

                $store_price = $add_store;

                // 課金にstores_idがある場合、店舗ない場合は項目なしになる
                if ($company->subscribedToPlan($stores_id, 'main')) {
                    // stores_idの決済方法をカンパニーでセグメントしてメインから取得
                    $subscriptionItem = $company->subscription('main')->findItemOrFail($stores_id);
                    // 該当idからquantity(店舗数)を取得
                    $stores_quantity = $subscriptionItem->quantity;
                    $stores_price = $stores_quantity * $store_price;
                } else {
                    $stores_quantity = '';
                    $stores_price = 0;
                }

                $stores_quantity = $stores_quantity + 1;


                if ($company->subscription('main')->onTrial()) {
                    // 試用期間中の場合は日付を返す
                    $trial_ends = $company->subscription('main')->trial_ends_at;
                } else {
                    $trial_ends = '';
                }
                // dd($payinfo, $trial_ends, $plan, $stores_quantity);

                // インボイス出力
                // $invoices = $company->invoices();

                return view('payment.card', compact('company', 'intent', 'payinfo', 'trial_ends', 'plan', 'laprice', 'stores_quantity', 'stores_price', 'trial_date', 'price_list'));
                // return view('payment.card', compact('company', 'intent', 'payinfo', 'trial_ends', 'plan', 'laprice', 'stores_quantity', 'stores_price', 'trial_date', 'price_list','invoices'));
            }
        } else {
            // 決済情報がない場合
            $time = new Carbon(Carbon::now());
            $trialtime = $time->addDay($trial_date);
            $trial = $trialtime->format('Y年m月d日');
            return view('payment.card', compact('company', 'intent', 'trial', 'trial_date', 'price_list'));
        }
    }

    // public function downloadInvoice(Request $request, $id)
    // {
    //     $user = Auth::user();
    //     $company = Company::where('id', $user->company_id)->first();

    //     return $company->downloadInvoice($id, [
    //         'header' => '毎度ありがとうございます',
    //         'receipt' => '領収書',
    //         'vendor' => 'Medjed, Llc.',
    //         // 'owner' => 'test',
    //         'product' => 'storemap',
    //         'street' => '218-14 Takenouchi',
    //         'location' => 'Katsuragi-shi Nara-ken',
    //         'phone' => '090-4285-3303',
    //         'url' => 'https://storemap.jp/',
    //     ]);
    // }
}
