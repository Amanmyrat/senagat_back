<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class CardOrders extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('resource.card');
    }
}
