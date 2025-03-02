<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Order;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $site_name;

    public function __construct(Order $order, $site_name )
    {
        $this->order = $order;
        $this->site_name = $site_name;
    }

    public function build()
    {
        return $this->subject('Confirmation de votre commande')
                    ->view('emails.order_confirmation');
    }
}
