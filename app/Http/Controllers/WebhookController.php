<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Illuminate\Support\Facades\Log;
use App\Models\Company;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscUpdateMail;
use App\Mail\SubscCreateMail;
use App\Mail\SubscCancelMail;
use App\Mail\SubscRestartMail;
use Illuminate\Support\Str;

class WebhookController extends CashierController
{
  // ユーザーが課金を作成・変更・キャンセル・カード期限切れの場合に、slackから通知が送られてくるように設定。受信した時の処理を記入
  public function handleInvoicePaymentSucceeded($payload)
  {
    // slack のヘルプに書いてる書き方、そのまま利用
    $endpoint_secret = config('services.stripe.webhook.secret');
    $payload = @file_get_contents('php://input');
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
    $event = null;

    try {
      $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sig_header,
        $endpoint_secret
      );
    } catch (\UnexpectedValueException $e) {
      // Invalid payload
      http_response_code(400);
      exit();
    } catch (\Stripe\Exception\SignatureVerificationException $e) {
      // Invalid signature
      http_response_code(400);
      exit();
    }

    // 配列から値を取り出す。
    $customer = $event->data->object->customer;
    $trial_end = $event->data->object->lines->data[0]->period->end;
    $company = Company::where('stripe_id', $customer)->first();
    $to = $company->company_email;
    $name = $company->company_name;
    $plan_a = $event->data->object->lines->data[0]->plan->nickname; // プラン
    $plan_b = $event->data->object->lines->data[1]->plan->nickname; // 追加店舗
    $price_a = $event->data->object->lines->data[0]->price->unit_amount;
    $price_b = $event->data->object->lines->data[1]->price->unit_amount;
    $quantity = $event->data->object->lines->data[1]->quantity;
    $card_brand = $company->card_brand;
    $card_last = $company->card_last_four;
    $price = number_format($price_b * $quantity + $price_a);
    $trial = date('Y-m-d H:i:s', $trial_end);

    // メール送信処理
    Mail::to($to)->send(new SubscCreateMail($name, $customer, $plan_a, $plan_b, $price, $quantity, $card_brand, $card_last, $trial));

    if (isset($trial)) {
      \Slack::channel('billing')->send("あっ、「" . $name . "(comapny_id:" . $company->id . ")」さんが課金してくれたよ。\nID:" . $customer . "\nプラン名:" . $plan_a . "\n追加店舗数:" . $quantity . "\n請求合計:" . $price . "円\n無料期間:" . $trial);
    } else {
      \Slack::channel('billing')->send("あっ、「" . $name . "(comapny_id:" . $company->id . ")」さんが課金してくれたよ。\nID:" . $customer . "\nプラン名:" . $plan_b . "\n追加店舗数:" . $quantity . "\n請求合計:" . $price . "円");
    }

    return response(200);
  }

  public function handleCustomerSubscriptionUpdated($payload)
  {
    // slack のヘルプに書いてる書き方、そのまま利用
    $endpoint_secret = config('services.stripe.webhook.secret');
    $payload = @file_get_contents('php://input');
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
    $event = null;

    try {
      $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sig_header,
        $endpoint_secret
      );
    } catch (\UnexpectedValueException $e) {
      // Invalid payload
      http_response_code(400);
      exit();
    } catch (\Stripe\Exception\SignatureVerificationException $e) {
      // Invalid signature
      http_response_code(400);
      exit();
    }

    // 配列から値を取り出す。
    $customer = $event->data->object->customer;
    $trial_end = $event->data->object->trial_end;

    $company = Company::where('stripe_id', $customer)->first();
    $to = $company->company_email;
    $name = $company->company_name;
    $plan_a = $event->data->object->items->data[0]->plan->nickname;
    $plan_b = $event->data->object->items->data[1]->plan->nickname;
    $price_a = $event->data->object->items->data[0]->plan->amount;
    $price_b = $event->data->object->items->data[1]->plan->amount;
    $quantity = $event->data->object->items->data[0]->quantity;
    $card_brand = $company->card_brand;
    $card_last = $company->card_last_four;
    $price = number_format($price_a * $quantity + $price_b);
    $trial = date('Y-m-d H:i:s', $trial_end);

    $cancel = $event->data->object->cancel_at_period_end;
    // Log::debug('抽出', [$cancel]);

    if($cancel === true){
      // キャンセルに変更したとき
      $cancel_endtime = $event->data->object->canceled_at; // キャンセルした日時
      $cancel_time = date('Y-m-d H:i:s', $cancel_endtime);

      Mail::to($to)->send(new SubscCancelMail($name, $customer, $plan_a, $plan_b, $quantity, $card_brand, $card_last, $trial, $cancel_time));

      // slack送信処理
      if (isset($trial)) {
        \Slack::channel('cancel')->send("あー！「" . $name . "(comapny_id:" . $company->id . ")」さんが課金をキャンセルしちゃったよ。\nID:" . $customer . "\nプラン名:" . $plan_b . "\n追加店舗数:" . $quantity . "\n請求合計:" . $price . "円\n無料期間:" . $trial . "\nキャンセル日時:" . $cancel_time);
      } else {
        \Slack::channel('cancel')->send("あー！「" . $name . "(comapny_id:" . $company->id . ")」さんが課金をキャンセルしちゃったよ。\nID:" . $customer . "\nプラン名:" . $plan_b . "\n追加店舗数:" . $quantity . "\n請求合計:" . $price . "円\nキャンセル日時:" . $cancel_time);
      }

      // Log::debug('キャンセル状態のとき', [$event]);
    } elseif( isset($event->data->previous_attributes->cancel_at_period_end)) {
      // $event->data->previous_attributes->cancel_at_period_endが存在するかどうか。課金変更のときは存在しないため、issetで調べないとエラーがでる。課金キャンセル状態では変更できないため、現状必ずtrueが入る。
      // キャンセル状態から復活したとき

      Mail::to($to)->send(new SubscRestartMail($name, $customer, $plan_a, $plan_b, $price, $quantity, $card_brand, $card_last, $trial));
      // slack送信処理
      if (isset($trial)) {
        \Slack::channel('recharge')->send("あっ、「" . $name . "(comapny_id:" . $company->id . ")」さんが課金を再開したよ。\nID:" . $customer . "\nプラン名:" . $plan_b . "\n追加店舗数:" . $quantity . "\n請求合計:" . $price . "円\n無料期間:" . $trial);
      } else {
        \Slack::channel('recharge')->send("あっ、「" . $name . "(comapny_id:" . $company->id . ")」さんが課金を再開したよ。\nID:" . $customer . "\nプラン名:" . $plan_b . "\n追加店舗数:" . $quantity . "\n請求合計:" . $price . "円");
      }

      // Log::debug('キャンセル状態から復活したとき', [$event]);
    } else {
      // 変更しただけのとき
      Mail::to($to)->send(new SubscUpdateMail($name, $customer, $plan_a, $plan_b, $price, $quantity, $card_brand, $card_last, $trial));

      // slack送信処理
      if (isset($trial)) {
        \Slack::channel('change')->send("「" . $name . "(comapny_id:" . $company->id . ")」さんが課金内容を変更したよ。\nID:" . $customer . "\nプラン名:" . $plan_b . "\n追加店舗数:" . $quantity . "\n請求合計:" . $price . "円\n無料期間:" . $trial);
      } else {
        \Slack::channel('change')->send("「" . $name . "(comapny_id:" . $company->id . ")」さんが課金内容を変更したよ。\nID:" . $customer . "\nプラン名:" . $plan_b . "\n追加店舗数:" . $quantity . "\n請求合計:" . $price . "円");
      }
      // Log::debug('変更したとき', [$event]);
    }

    return response(200);
  }

}
