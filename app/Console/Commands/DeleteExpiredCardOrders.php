<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CardOrder;

class DeleteExpiredCardOrders extends Command
{

    protected $signature = 'card-orders:cleanup';

    protected $description = 'Deletes card orders with draft status older than 3 days.';


    public function handle(): void
    {
        $count = CardOrder::where('status', 'draft')
            ->where('expires_at', '<', now())
            ->delete();

        $this->info("Number of deleted draft records: {$count}");
    }
}
