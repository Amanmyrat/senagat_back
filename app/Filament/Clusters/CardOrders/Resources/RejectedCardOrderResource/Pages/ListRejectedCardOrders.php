<?php

namespace App\Filament\Clusters\CardOrders\Resources\RejectedCardOrderResource\Pages;

use App\Filament\Clusters\CardOrders\Resources\RejectedCardOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRejectedCardOrders extends ListRecords
{
    protected static string $resource = RejectedCardOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
