<?php

namespace App\Filament\Clusters\CardOrders\Resources\ApprovedCardOrderResource\Pages;

use App\Filament\Clusters\CardOrders\Resources\ApprovedCardOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApprovedCardOrders extends ListRecords
{
    protected static string $resource = ApprovedCardOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
