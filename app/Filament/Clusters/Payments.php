<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Payments extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?int $navigationSort = 6;

    public static function getNavigationLabel(): string
    {
        return __('navigation.payment');
    }
}
