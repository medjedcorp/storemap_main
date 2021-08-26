<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DataWorkerErrorMail extends Mailable
{
    use Queueable, SerializesModels;

    // protected $title;
    // protected $text;
    // protected $upload_filename;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company_name, $errorLists, $site)
    {
      $this->company_name = $company_name;
      $this->errorLists = $errorLists;
      $this->site = $site;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->view('emails.worker_error')
                  ->text('emails.worker_error_plain')
                  // ->subject($this->title)
                  ->from('system@storemap.jp')
                  ->subject('※データ連携エラーのお知らせ[Storemap]')
                  ->with([
                        'company_name' => $this->company_name,
                        'errorLists' => $this->errorLists,
                        'site' => $this->site,
                    ]);
    }
}
