<?php

namespace App\Filament\Clusters\CardOrders\Resources\ApprovedCardOrderResource\Pages;

use App\Filament\Clusters\CardOrders\Resources\ApprovedCardOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovedCardOrder extends EditRecord
{
    protected static string $resource = ApprovedCardOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
