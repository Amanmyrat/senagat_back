<?php

namespace App\Filament\Clusters\CardOrders\Resources\RejectedCardOrderResource\Pages;

use App\Filament\Clusters\CardOrders\Resources\RejectedCardOrderResource;
use Filament\Resources\Pages\ListRecords;

class ListRejectedCardOrders extends ListRecords
{
    protected static string $resource = RejectedCardOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
