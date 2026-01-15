<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Messages\MailMessage;

class RegisterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $user, public $url) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vérification de votre adresse e-mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify', // Matches view below
            with: ['url' => $this->url, 'user' => $this->user]
        );
    }
}
