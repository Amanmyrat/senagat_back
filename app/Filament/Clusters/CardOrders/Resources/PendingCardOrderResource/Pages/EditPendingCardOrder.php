<?php

namespace App\Filament\Clusters\CardOrders\Resources\PendingCardOrderResource\Pages;

use App\Filament\Clusters\CardOrders\Resources\PendingCardOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendingCardOrder extends EditRecord
{
    protected static string $resource = PendingCardOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
