<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Illuminate\Support\Facades\Log;

class WebhookController extends CashierController
// class StripeController extends \Laravel\Cashier\Http\Controllers\WebhookController
// class StripeController extends CashierController
{
  public function handleInvoicePaymentSucceeded($payload)
  {
    $info = print_r($payload, TRUE);
    // $this->mailtoAdmin($info);
    Log::debug('決済テスト',$payload);
  }

  public function handleCustomerSubscriptionUpdated($payload)
  {
    // 店舗が決済内容変更した場合に、stripeからここに値が戻ってくる。
    // メール送信したり、slack設定する場合はここ。
    // envのSTRIPE_WEBHOOK_SECRETと、stipe側の署名シークレットを一緒にすること
    Log::debug('CustomerSubscriptionUpdated', $payload);
    // Log::debug('CustomerSubscriptionUpdated',['payload' => $payload]);
    return response(200);
  }

  public function handleInvoicePaymentFailed($payload)
  {
    $billable = $this->getBillable(
      $payload['data']['object']['customer']
    );

    if ($billable) {
      \Mail::send(
        'emails.failed_charge',
        compact('billable'),
        function ($message) {
          $message->to(env('MAIL_FROM'), env('MAIL_NAME'));
          $message->subject('WeDewLawns.com Payment Failed');
        }
      );
    }

    return new Response('Webhook Handled', 200);
  }
}
