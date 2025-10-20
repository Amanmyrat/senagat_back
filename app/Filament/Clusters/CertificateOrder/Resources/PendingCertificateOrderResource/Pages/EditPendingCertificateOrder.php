<?php

namespace App\Filament\Clusters\CertificateOrder\Resources\PendingCertificateOrderResource\Pages;

use App\Filament\Clusters\CertificateOrder\Resources\PendingCertificateOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendingCertificateOrder extends EditRecord
{
    protected static string $resource = PendingCertificateOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
