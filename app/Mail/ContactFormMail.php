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
        return $this->from('contact@sportclubpro.ro')
            ->replyTo($this->data['email'], $this->data['name'])
            ->subject('Contact Form: ' . $this->data['subject'])
            ->html("
                    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                        <h2 style='color: #008080;'>Mesaj Nou din Formularul de Contact</h2>
                        <div style='background-color: #f9f9f9; padding: 20px; border-radius: 5px;'>
                            <p><strong>Nume:</strong> {$this->data['name']}</p>
                            <p><strong>Email:</strong> {$this->data['email']}</p>
                            <p><strong>Subiect:</strong> {$this->data['subject']}</p>
                            <p><strong>Mesaj:</strong><br>{$this->data['message']}</p>
                        </div>
                    </div>
                ");
    }
}
