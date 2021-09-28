<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportSendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $company;
    protected $email;
    protected $name;
    protected $detail;
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
        $this->company = $inputs['company'];
        $this->email = $inputs['email'];
        $this->name = $inputs['name'];
        $this->detail  = $inputs['detail'];
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
            ->subject('お問い合わせを受け付けました[Storemap]')
            ->view('support.mail')
            ->with([
                'company' => $this->company,
                'email' => $this->email,
                'name' => $this->name,
                'detail'  => $this->detail,
            ]);
    }
}
