<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentSyncService
{
    public function sync(Location $location): void
    {
        Log::channel('payment_webhook')->info('SYNC STARTED', [
            'url' => config('services.payment.url'),
            'location_id' => $location->id,
        ]);
        $response =  Http::withToken(config('services.payment_api.token'))->post(
            config('services.payment_api.url') . '/api/v1/merchant/sync',
            [
                'location_id' => $location->id,
                'username' => $location->payment_username,
                'password' => $location->payment_password,
            ]
        );
        Log::channel('payment_webhook')->info('SYNC RESPONSE', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
    }
}
