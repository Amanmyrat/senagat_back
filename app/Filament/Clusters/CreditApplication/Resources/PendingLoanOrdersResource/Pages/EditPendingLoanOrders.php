<?php

namespace App\Filament\Clusters\CreditApplication\Resources\PendingLoanOrdersResource\Pages;

use App\Filament\Clusters\CreditApplication\Resources\PendingLoanOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendingLoanOrders extends EditRecord
{
    protected static string $resource = PendingLoanOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
