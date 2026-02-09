<?php

namespace App\Jobs;

use App\Models\PaymentRequest;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AutoConfirmPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;

    public function __construct(
        public string $providerClass,
        public string|int $orderId,
        public $startTime = null
    ) {
        $this->startTime = $startTime ?? now();
    }

    public function handle()
    {
        Log::channel('belet')->info('--- JOB STARTED ---', ['id_sent' => $this->orderId]);

        $payment = is_numeric($this->orderId)
            ? PaymentRequest::find($this->orderId)
            : PaymentRequest::where('external_id', $this->orderId)->first();

        if (! $payment) {
            Log::channel('belet')->error('JOB ABORTED: Kayıt bulunamadı.', ['sent_value' => $this->orderId]);

            return;
        }

        if ($payment->status === 'confirmed') {
            Log::channel('belet')->info('JOB STOPPED: Payment already confirmed.', [
                'payment_id' => $payment->id,
            ]);

            return;
        }

        $start = Carbon::parse($this->startTime);
        if ($start->diffInSeconds(now()) > 1200) {
            $payment->update(['status' => 'failed', 'error_message' => 'Payment polling timeout (20 mins)']);
            Log::channel('belet')->warning('JOB TERMINATED: 20 mins limit reached.', ['payment_id' => $payment->id]);

            return;
        }

        try {
            $service = app($this->providerClass);

            $result = $service->pollStatusByOrderId($this->orderId);

            Log::channel('belet')->info('Polling Result:', ['payment_id' => $payment->id, 'result' => $result]);

            if (! ($result['success'] ?? false)) {
                Log::channel('belet')->info('CHAIN CONTINUES: Re-dispatching in 30s.', ['payment_id' => $payment->id]);

                self::dispatch($this->providerClass, $this->orderId, $this->startTime)
                    ->delay(now()->addSeconds(30));
            } else {
                Log::channel('belet')->info('CHAIN BROKEN: Payment confirmed.', ['payment_id' => $payment->id]);
            }

        } catch (\Exception $e) {
            Log::channel('belet')->error('JOB FAILED: Exception occurred.', [
                'payment_id' => $this->orderId,
                'message' => $e->getMessage(),
            ]);

            self::dispatch($this->providerClass, $this->orderId, $this->startTime)
                ->delay(now()->addSeconds(30));
        }
    }
}
