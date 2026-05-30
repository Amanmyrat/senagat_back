<?php

namespace App\Observers;

use App\Jobs\SyncLocationJob;
use App\Models\Location;
use App\Services\PaymentSyncService;
use Illuminate\Support\Facades\Log;

class LocationObserver
{
    public function saved(Location $location): void
    {
        SyncLocationJob::dispatch($location->id);
    }
}
