<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $name;
    protected $body;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inputs)
    {
        // $this->email = $inputs->email;
        // $this->title = $inputs->title;
        // $this->body  = $inputs->body;
        $this->email = $inputs['email'];
        $this->name = $inputs['name'];
        $this->body  = $inputs['body'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('system@storemap.jp')
            ->subject('お問い合わせありがとうございます[Storemap]')
            ->view('contact.mail')
            ->with([
                'email' => $this->email,
                'name' => $this->name,
                'body'  => $this->body,
            ]);
    }
}
