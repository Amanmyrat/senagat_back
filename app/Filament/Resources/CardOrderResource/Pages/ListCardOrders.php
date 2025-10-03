<?php

namespace App\Filament\Resources\CardOrderResource\Pages;

use App\Filament\Resources\CardOrderResource;
use Filament\Resources\Pages\ListRecords;

class ListCardOrders extends ListRecords
{
    protected static string $resource = CardOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
