<?php

namespace App\Filament\Clusters\CreditApplication\Resources\RejectedLoanOrdersResource\Pages;

use App\Filament\Clusters\CreditApplication\Resources\RejectedLoanOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRejectedLoanOrders extends ListRecords
{
    protected static string $resource = RejectedLoanOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
