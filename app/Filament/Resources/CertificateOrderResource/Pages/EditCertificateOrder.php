<?php

namespace App\Filament\Resources\CertificateOrderResource\Pages;

use App\Filament\Resources\CertificateOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCertificateOrder extends EditRecord
{
    protected static string $resource = CertificateOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
