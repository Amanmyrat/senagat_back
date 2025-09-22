<?php

namespace App\Filament\Resources\CertificateOrderResource\Pages;

use App\Filament\Resources\CertificateOrderResource;
use Filament\Resources\Pages\ListRecords;

class ListCertificateOrders extends ListRecords
{
    protected static string $resource = CertificateOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
