<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTokenizedLink extends Mailable
{
    use Queueable, SerializesModels;
    
    public $tokenized_link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tokenized_link)
    {
        $this->tokenized_link = $tokenized_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.tokenized_link');
    }
}
