<?php

namespace App\Filament\Clusters\CreditApplication\Resources\ApprovedLoanOrdersResource\Pages;

use App\Filament\Clusters\CreditApplication\Resources\ApprovedLoanOrdersResource;
use Filament\Resources\Pages\ListRecords;

class ListApprovedLoanOrders extends ListRecords
{
    protected static string $resource = ApprovedLoanOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
