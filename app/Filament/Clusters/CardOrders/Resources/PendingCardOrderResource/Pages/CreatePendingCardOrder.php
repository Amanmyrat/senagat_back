<?php

namespace App\Filament\Clusters\CardOrders\Resources\PendingCardOrderResource\Pages;

use App\Filament\Clusters\CardOrders\Resources\PendingCardOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePendingCardOrder extends CreateRecord
{
    protected static string $resource = PendingCardOrderResource::class;
}
