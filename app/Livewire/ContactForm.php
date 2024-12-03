<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $subject;
    public $message;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'subject' => 'required|min:5',
        'message' => 'required|min:10'
    ];

    public function submitForm()
    {
        $validatedData = $this->validate();

        // Trimite email
        Mail::to('support@sportclubpro.com')->send(new \App\Mail\ContactFormMail($validatedData));

        session()->flash('message', 'Mesajul a fost trimis cu succes!');
        $this->reset(['name', 'email', 'subject', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}