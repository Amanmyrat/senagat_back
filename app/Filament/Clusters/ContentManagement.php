<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class ContentManagement extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    protected static ?int $navigationSort = 4;

    public static function getNavigationLabel(): string
    {
        return __('navigation.content_management');
    }
}
