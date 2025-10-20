<?php

namespace App\Filament\Clusters\CertificateOrder\Resources\RejectedCertificateOrderResource\Pages;

use App\Filament\Clusters\CertificateOrder\Resources\RejectedCertificateOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRejectedCertificateOrders extends ListRecords
{
    protected static string $resource = RejectedCertificateOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
