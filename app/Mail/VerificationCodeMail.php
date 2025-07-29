<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $loginUrl;

    public function __construct(
        public string $email,
        public string $code
    ) {
        $this->loginUrl = route('magic-link.verify').'?'.http_build_query([
            'email' => $this->email,
            'token' => $this->code,
        ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Login Code',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verification-code',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
