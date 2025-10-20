<?php

namespace App\Filament\Clusters\CreditApplication\Resources\PendingLoanOrdersResource\Pages;

use App\Filament\Clusters\CreditApplication\Resources\PendingLoanOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendingLoanOrders extends ListRecords
{
    protected static string $resource = PendingLoanOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
