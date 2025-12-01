<?php

namespace App\Filament\Resources\InternationalPaymentOrderResource\Pages;

use App\Filament\Resources\InternationalPaymentOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInternationalPaymentOrder extends EditRecord
{
    protected static string $resource = InternationalPaymentOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
