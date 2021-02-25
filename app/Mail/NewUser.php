<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Withdrawal;

class NewUser extends Mailable
{
    use Queueable, SerializesModels;
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('text.welcomeSubject'))->view('emails.welcome-email');
    }
}
