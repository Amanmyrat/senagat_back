<?php

namespace App\Filament\Clusters\CertificateOrder\Resources\RejectedCertificateOrderResource\Pages;

use App\Filament\Clusters\CertificateOrder\Resources\RejectedCertificateOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRejectedCertificateOrder extends EditRecord
{
    protected static string $resource = RejectedCertificateOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
