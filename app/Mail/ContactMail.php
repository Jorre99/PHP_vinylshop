<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = strtolower($this->request->contact).'@thevinylshop.com';
        $name = 'The Vinyl Shop - '.$this->request->contact;
        return $this->from($address, $name)
            ->cc($address, $name)
            ->subject('The Vinyl Shop - Contact Form')
            ->markdown('email.contact');
    }
}
