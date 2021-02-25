<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerSendBacsForReject extends Mailable
{
    use Queueable, SerializesModels;
    
    public $bank_info;
    public $tokenized_link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bank_info,$tokenized_link)
    {
        $this->bank_info = $bank_info;
        $this->tokenized_link = $tokenized_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('text.underpayment'))->view('emails.customerSendRejectedForBacs');
    }
}
