<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportReceiveMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $company;
    protected $cid;
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
        $this->cid = $inputs['cid'];
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
            ->subject('ご契約中店舗からのお問い合わせ[StoremapSystem]')
            ->view('support.receive')
            ->with([
                'company' => $this->company,
                'cid' => $this->cid,
                'email' => $this->email,
                'name' => $this->name,
                'detail'  => $this->detail,
            ]);
    }
}
