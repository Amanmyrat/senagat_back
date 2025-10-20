<?php

namespace App\Filament\Clusters\CreditApplication\Resources\ApprovedLoanOrdersResource\Pages;

use App\Filament\Clusters\CreditApplication\Resources\ApprovedLoanOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovedLoanOrders extends EditRecord
{
    protected static string $resource = ApprovedLoanOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
