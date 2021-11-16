<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use Laravel\Cashier\Cashier;
use Log;

class SubscriptionController extends Controller
{
    // 課金を実行
    public function subscribe(Request $request)
    {
        $stores_id = config('services.stripe.stores');
        $trial = config('services.stripe.trial');

        $user = $request->user();
        $company = Company::where('id', $user->company_id)->first();

        // if (!$company->subscribed('main') and !$company->hasDefaultPaymentMethod()) {

            $payment_method = $request->payment_method;
            $plan = $request->plan;
            $stores_num = $request->storeNum;

            // if(!$plan or !$stores_num or !$payment_method){
            //     abort(404); // 503
            // }
            // Log::debug($stores_num);

            if(!$plan){                
                return response()->json([
                    'message' => 'プランを選択してください',
                ], 404);
            } elseif($stores_num === null) {
                // 0件の場合は除外するから、nullだけtrue
                return response()->json([
                    'message' => '店舗数を選択してください',
                ], 404);
            } elseif(!$payment_method) {
                return response()->json([
                    'message' => 'カード情報を入力してください',
                ], 404);
            }

            // トライアルなし
            // $company->newSubscription('main', [$plan, $stores_id])->quantity($stores_num, $stores_id)->create($payment_method, [
            // トライアルあり
            $company->newSubscription('main', [$plan, $stores_id])->quantity($stores_num, $stores_id)->trialDays($trial)->create($payment_method, [
                'name' => $company->company_name,
                'description' => $company->id,
                'email' => $user->email,
                // 'collection_method' => 'send_invoice',
                // 'days_until_due' => 30,
            ]);
            $company->load('subscriptions');
        // }

        $user->role = 'seller';
        $user->save();

        $company->status = 1;
        $company->save();

        // \Slack::channel('billing')->send('あっ、「'.$company->company_name.'(comapny_id:'.$company->id.')」さんが課金してくれたよ！');

        return $this->status();

    }

    // 課金をキャンセル
    public function cancel(Request $request)
    {
        $user = $request->user();
        $company = Company::where('id', $user->company_id)->first();
        
        $company->subscription('main')->cancel(); // 30日有効期限つきキャンセル
        // $company->subscription('main')->cancelNow(); // 即座にキャンセル
        $company->status = 0;
        $company->api_flag = 0;
        $company->save();

        // \Slack::channel('cancel')->send('あー！「'.$company->company_name.'(comapny_id:'.$company->id.')」さんが課金をキャンセルしちゃったよ。');

        $user->role = 'free';
        $user->save();        

        return $this->status();
    }

    // キャンセルしたものをもとに戻す
    public function resume(Request $request)
    {
        $user = $request->user();
        $company = Company::where('id', $user->company_id)->first();
        // $company->subscription('main')->trialDays(1)->resume();
        $company->subscription('main')->resume();

        // \Slack::channel('recharge')->send('あっ、「'.$company->company_name.'(comapny_id:'.$company->id.')」さんが再課金してくれたよ。');
        $user->role = 'seller';
        $user->save();

        return $this->status();
    }

    // プランを変更する
    public function change_plan(Request $request)
    {
        $stores_id = config('services.stripe.stores');

        $plan = $request->plan;
        $user = $request->user();
        $company = Company::where('id', $user->company_id)->first();
        $stores_num = $request->storeNum;

        if(!$plan){                
            return response()->json([
                'message' => 'プランを選択してください',
            ], 404);
        } elseif(!$stores_num < 0) {
            return response()->json([
                'message' => '店舗数の指定に誤りがあります',
            ], 404);
        }

        $company->subscription('main')->swap([
            $stores_id => ['quantity' => $stores_num],
            $plan
        ]);

        // \Slack::channel('change')->send('「'.$company->company_name.'(comapny_id:'.$company->id.')」さんが課金内容を変更したよ。');

        return $this->status();
    }

    // カードを変更する
    public function update_card(Request $request)
    {
        $payment_method = $request->payment_method;
        $user = $request->user();
        $company = Company::where('id', $user->company_id)->first();
        $company->updateDefaultPaymentMethod($payment_method);

        return $this->status();
    }

    // 課金状態を返す
    public function status()
    {
        $status = 'unsubscribed';
        $user = auth()->user();
        $company = Company::where('id', $user->company_id)->first();
        $details = [];

        if ($company->subscribed('main')) { // 課金履歴あり
            if ($company->subscription('main')->cancelled()) {  // キャンセル済み
                $status = 'cancelled';
            } else {    // 課金中
                $status = 'subscribed';
            }
            $subscription = $company->subscriptions->first(function ($value) {
                return ($value->name === 'main');
            })->only('ends_at');
  
            // ストア数のプランをconfigより取得
            $stores = config('services.stripe.stores'); 
            // ストア数プラン以外で、引っかかるプランを取得(店舗数)
            $subscriptionItem = $company->subscription('main')->items->whereNotIn('stripe_plan', $stores)->first();
            // ストア数のプランを取得
            $storesItem = $company->subscription('main')->items->where('stripe_plan', $stores)->first();
            // プラン名を取得
            $stripePlan = $subscriptionItem->stripe_plan;
            // 店舗数を取得
            $quantity = $storesItem->quantity;
            // Log::debug($stripePlan);
            $details = [
                'end_date' => ($subscription['ends_at']) ? $subscription['ends_at']->format('Y-m-d') : null,
                'plan' => \Arr::get(config('services.stripe.plans'), $stripePlan),
                'card_last_four' => $company->card_last_four,
                'quantity' => $quantity + 1
            ];
        }
        
        return [
            'status' => $status,
            'details' => $details
        ];
    }
}
