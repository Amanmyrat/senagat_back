<?php

namespace App\Filament\Clusters\CertificateOrder\Resources\ApprovedCertificateOrderResource\Pages;

use App\Filament\Clusters\CertificateOrder\Resources\ApprovedCertificateOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApprovedCertificateOrders extends ListRecords
{
    protected static string $resource = ApprovedCertificateOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
