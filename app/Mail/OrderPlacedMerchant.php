<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Order;

class OrderPlacedMerchant extends Mailable
{
    use Queueable, SerializesModels;
    
    public $order;
    public $order_from;
    public $order_to;

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
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order-placed')->with([
            'order_from' => $this->order->from,
            'order_to' => $this->order->to
            ]);
    }
}
