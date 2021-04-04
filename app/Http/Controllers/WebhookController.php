<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use App\Notifications\InvoicePaid;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Subscription;
use App\Models\Company;


class WebhookController extends CashierController
{

    // public function handleCustomerUpdated($payload){
    //     return new Response('Webhook Handled', 200);
    // }
    // public function handlePaymentIntentSucceeded($payload)
    // {
    //     return new Response('Webhook Handled', 200);
    // }

    // public function handlePaymentIntentCreated($payload)
    // {
    //     return new Response('Webhook Handled', 200);
    // }

    // public function handleInvoicePaymentSucceeded($payload)
    // {
       
    //     $invoice = $payload['data']['object'];
    //     $user = $this->getUserByStripeId($invoice['customer']);

    //     if ($user) {
    //         $user->notify(new InvoicePaid($invoice));
    //     }

    //     return new Response('Webhook Handled', 200);
    // }

    // public function handleCustomerSubscriptionUpdated(array $payload)
    // {

    //     return new Response('Webhook Handled', 200);
    // }
    // public function handleInvoiceCreated(array $payload)
    // {

    //     return new Response('Webhook Handled', 200);
    // }
    
}
