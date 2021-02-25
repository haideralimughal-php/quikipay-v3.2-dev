<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\BacsTransaction;
use App\BacsDeposit;

class BacsCustomerCompleted extends Mailable
{
    use Queueable, SerializesModels;
    
    public $transaction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BacsDeposit $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('text.bacsCompletedSubject'))->view('emails.customer-transaction-completed');
    }
}
