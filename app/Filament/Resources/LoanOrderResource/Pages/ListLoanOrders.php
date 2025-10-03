<?php

namespace App\Filament\Resources\LoanOrderResource\Pages;

use App\Filament\Resources\LoanOrderResource;
use Filament\Resources\Pages\ListRecords;

class ListLoanOrders extends ListRecords
{
    protected static string $resource = LoanOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
