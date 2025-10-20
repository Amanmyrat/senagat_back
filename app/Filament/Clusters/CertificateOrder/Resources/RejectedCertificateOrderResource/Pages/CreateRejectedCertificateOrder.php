<?php

namespace App\Filament\Clusters\CertificateOrder\Resources\RejectedCertificateOrderResource\Pages;

use App\Filament\Clusters\CertificateOrder\Resources\RejectedCertificateOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRejectedCertificateOrder extends CreateRecord
{
    protected static string $resource = RejectedCertificateOrderResource::class;
}
