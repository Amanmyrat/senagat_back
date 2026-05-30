<?php

namespace App\Jobs;

use App\Models\Location;
use App\Services\PaymentSyncService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncLocationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $locationId;


    public int $tries = 5;
    public int $timeout = 30;
    public array $backoff = [5, 15, 60, 120, 300];

    public function __construct(int $locationId)
    {
        $this->locationId = $locationId;
    }

    public function handle(PaymentSyncService $service): void
    {
        $location = Location::find($this->locationId);

        if (!$location) {
            return;
        }

        $location = $location->fresh();
        $service->sync($location);

    }

}
