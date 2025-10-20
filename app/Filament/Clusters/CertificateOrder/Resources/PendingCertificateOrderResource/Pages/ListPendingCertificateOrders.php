<?php

namespace App\Filament\Clusters\CertificateOrder\Resources\PendingCertificateOrderResource\Pages;

use App\Filament\Clusters\CertificateOrder\Resources\PendingCertificateOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendingCertificateOrders extends ListRecords
{
    protected static string $resource = PendingCertificateOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
