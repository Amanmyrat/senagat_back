<?php

namespace App\Filament\Clusters\CardOrders\Resources\PendingCardOrderResource\Pages;

use App\Filament\Clusters\CardOrders\Resources\PendingCardOrderResource;
use Filament\Resources\Pages\ListRecords;

class ListPendingCardOrders extends ListRecords
{
    protected static string $resource = PendingCardOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
