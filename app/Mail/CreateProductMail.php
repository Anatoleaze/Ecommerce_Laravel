<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreateProductMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactData;

    /**
     * Create a new message instance.
     *
     * @param array $contactData
     * @return void
     */
    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }
   
    public function build()
    {
      
        return $this->subject('Nouveau(x) Produit(s) dans notre boutique')
                    ->view('emails.createProduct');
    }

    
}
