<?php

namespace App\Filament\Clusters\CreditApplication\Resources\RejectedLoanOrdersResource\Pages;

use App\Filament\Clusters\CreditApplication\Resources\RejectedLoanOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRejectedLoanOrders extends EditRecord
{
    protected static string $resource = RejectedLoanOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
