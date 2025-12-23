<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class InternationalPayment extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?int $navigationSort = 6;

    public static function getNavigationLabel(): string
    {
        return __('resource.international_payment');
    }
}
