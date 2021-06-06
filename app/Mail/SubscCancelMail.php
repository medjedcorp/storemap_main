<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscCancelMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $customer, $plan_a, $plan_b, $quantity, $card_brand, $card_last, $trial, $cancel_time)
    {
        $this->name = $name;
        $this->customer = $customer;
        $this->plan_a = $plan_a;
        $this->plan_b = $plan_b;
        $this->cancel_time = $cancel_time;
        $this->quantity = $quantity;
        $this->card_brand = $card_brand;
        $this->card_last = $card_last;
        $this->trial = $trial;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.stripe_cancel')
        ->text('emails.stripe_cancel_plain')
        ->from('system@storemap.jp')
        ->subject('※課金キャンセルのお知らせ[Storemap]')
        ->with([
              'name' => $this->name,
              'customer' => $this->customer,
              'plan_a' => $this->plan_a,
              'plan_b' => $this->plan_b,
              'cancel_time' => $this->cancel_time,
              'quantity' => $this->quantity,
              'card_brand' => $this->card_brand,
              'card_last' => $this->card_last,
              'trial' => $this->trial,
          ]);
    }
}
