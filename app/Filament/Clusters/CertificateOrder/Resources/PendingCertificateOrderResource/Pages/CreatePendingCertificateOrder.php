<?php

namespace App\Filament\Clusters\CertificateOrder\Resources\PendingCertificateOrderResource\Pages;

use App\Filament\Clusters\CertificateOrder\Resources\PendingCertificateOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePendingCertificateOrder extends CreateRecord
{
    protected static string $resource = PendingCertificateOrderResource::class;
}
