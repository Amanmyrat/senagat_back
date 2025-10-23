<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected function schedule(Schedule $schedule): void
    {

        $schedule->command('card-orders:cleanup')->dailyAt('13:25');
    }


    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
