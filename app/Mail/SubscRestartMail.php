<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscRestartMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $customer, $plan_a, $plan_b, $price, $quantity, $card_brand, $card_last, $trial)
    {
        $this->name = $name;
        $this->customer = $customer;
        $this->plan_a = $plan_a;
        $this->plan_b = $plan_b;
        $this->price = $price;
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
        return $this->view('emails.stripe_restart')
        ->text('emails.stripe_restart_plain')
        // ->subject($this->title)
        ->from('system@storemap.jp')
        ->subject('※お支払い再開のお知らせ[Storemap]')
        ->with([
              'name' => $this->name,
              'customer' => $this->customer,
              'plan_a' => $this->plan_a,
              'plan_b' => $this->plan_b,
              'price' => $this->price,
              'quantity' => $this->quantity,
              'card_brand' => $this->card_brand,
              'card_last' => $this->card_last,
              'trial' => $this->trial,
          ]);
    }
}
