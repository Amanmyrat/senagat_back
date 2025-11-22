<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Tariffs extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?int $navigationSort = 5;

    public static function getNavigationLabel(): string
    {
        return __('navigation.tariffs');
    }
}
