<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Order;

class OrderPlacedAdmin extends Mailable
{
    use Queueable, SerializesModels;
    
    public $order;
    public $order_from;
    public $order_to;
    public $order_user;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
        $this->order_from = $order->from;
        $this->order_to = $order->to;
        $this->order_user = $order->user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order-placed-admin');
    }
}
