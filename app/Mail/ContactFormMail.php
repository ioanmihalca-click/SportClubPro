<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ContactFormMail extends Mailable
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from($this->data['email'])
                    ->subject('Contact Form: ' . $this->data['subject'])
                    ->view('emails.contact-form');
    }
}
