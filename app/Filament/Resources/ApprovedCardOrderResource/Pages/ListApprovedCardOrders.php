<?php

namespace App\Filament\Resources\ApprovedCardOrderResource\Pages;

use App\Filament\Resources\ApprovedCardOrderResource;
use Filament\Resources\Pages\ListRecords;

class ListApprovedCardOrders extends ListRecords
{
    protected static string $resource = ApprovedCardOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
