<?php

namespace App\Jobs;

use App\Models\ContactMessage;
use App\Models\ContactMailRecipient;
use App\Mail\ContactMessageMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Throwable;

class SendContactMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $tries = 3;

    /**
     * Timeout
     */
    public $timeout = 30;

    protected ContactMessage $message;

    /**
     * Create a new job instance.
     */
    public function __construct(ContactMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $recipients = ContactMailRecipient::query()
            ->where('is_active', true)
            ->pluck('email');

        if ($recipients->isEmpty()) {
            return;
        }

        foreach ($recipients as $email) {
            Mail::to($email)->send(
                new ContactMessageMail($this->message)
            );
        }
    }


    public function failed(Throwable $exception): void
    {

        Log::error('Contact mail not send', [
            'message_id' => $this->message->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
