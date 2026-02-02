<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\PaymentRequest;
use Illuminate\Support\Facades\Log;

class AutoConfirmPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $tries = 20;

    public function __construct(
        public string $providerClass,
        public string|int $orderId
    ) {}

    public function handle()
    {
        Log::channel('belet')->info("--- JOB STARTED ---", ['payment_id' => $this->orderId]);

        $payment = PaymentRequest::find($this->orderId);

        if (!$payment) {
            Log::channel('belet')->error("JOB ABORTED: Payment record not found.", ['payment_id' => $this->orderId]);
            return;
        }

        // 20-minute timeout check (1200 seconds)
        if ($payment->created_at->diffInSeconds(now()) > 1200) {
            $payment->update(['status' => 'failed', 'error_message' => 'Payment polling timeout (20 mins)']);
            Log::channel('belet')->warning("JOB TERMINATED: Timeout reached for payment.", ['payment_id' => $this->orderId]);
            return;
        }

        if (in_array($payment->status, ['confirmed', 'failed'])) {
            Log::channel('belet')->info("JOB STOPPED: Payment already in final state.", [
                'payment_id' => $this->orderId,
                'status' => $payment->status
            ]);
            return;
        }

        try {
            $service = app($this->providerClass);
            $result = $service->pollStatusByOrderId($this->orderId);

            Log::channel('belet')->info("Polling Result:", ['payment_id' => $this->orderId, 'result' => $result]);

            if (!($result['success'] ?? false)) {
                Log::channel('belet')->info("CHAIN CONTINUES: Re-dispatching job in 30 seconds.", ['payment_id' => $this->orderId]);

                self::dispatch($this->providerClass, $this->orderId)
                    ->delay(now()->addSeconds(30));
            } else {
                Log::channel('belet')->info("CHAIN BROKEN: Payment confirmed or process finished.", ['payment_id' => $this->orderId]);
            }
        } catch (\Exception $e) {
            Log::channel('belet')->error("JOB FAILED: Exception occurred during polling.", [
                'payment_id' => $this->orderId,
                'message' => $e->getMessage()
            ]);


        }
    }
}
