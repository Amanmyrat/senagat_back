<?php

namespace App\Filament\Clusters\CertificateOrder\Resources\ApprovedCertificateOrderResource\Pages;

use App\Filament\Clusters\CertificateOrder\Resources\ApprovedCertificateOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovedCertificateOrder extends EditRecord
{
    protected static string $resource = ApprovedCertificateOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
