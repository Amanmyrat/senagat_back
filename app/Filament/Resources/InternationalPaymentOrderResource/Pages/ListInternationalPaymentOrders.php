<?php

namespace App\Filament\Resources\InternationalPaymentOrderResource\Pages;

use App\Filament\Resources\InternationalPaymentOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInternationalPaymentOrders extends ListRecords
{
    protected static string $resource = InternationalPaymentOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
