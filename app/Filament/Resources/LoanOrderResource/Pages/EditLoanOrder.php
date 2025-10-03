<?php

namespace App\Filament\Resources\LoanOrderResource\Pages;

use App\Filament\Resources\LoanOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLoanOrder extends EditRecord
{
    protected static string $resource = LoanOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
