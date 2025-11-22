<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class CertificateOrder extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel(): string
    {
        return __('navigation.certificate');
    }
}
