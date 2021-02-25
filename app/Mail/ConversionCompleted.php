<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConversionCompleted extends Mailable
{
    use Queueable, SerializesModels;
    
    public $conversion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conversion)
    {
        $this->conversion = $conversion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('text.conversionSubject'))->view('emails.conversion-completed');
    }
}
