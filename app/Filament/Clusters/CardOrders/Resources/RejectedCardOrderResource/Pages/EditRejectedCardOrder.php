<?php

namespace App\Filament\Clusters\CardOrders\Resources\RejectedCardOrderResource\Pages;

use App\Filament\Clusters\CardOrders\Resources\RejectedCardOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRejectedCardOrder extends EditRecord
{
    protected static string $resource = RejectedCardOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
