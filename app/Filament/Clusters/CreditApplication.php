<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class CreditApplication extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('navigation.loan');
    }
}
