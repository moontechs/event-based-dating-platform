<?php

namespace App\Jobs;

use App\Mail\VerificationCodeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendVerificationCodeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $email,
        public string $code
    ) {
        $this->onQueue('emails');
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new VerificationCodeMail($this->email, $this->code));
    }

    public function failed(?\Throwable $exception): void
    {
        Log::error('Failed to send verification code email', [
            'email' => $this->email,
            'error' => $exception?->getMessage(),
        ]);
    }
}
