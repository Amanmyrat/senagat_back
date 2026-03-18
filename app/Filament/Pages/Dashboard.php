<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getTitle(): string
    {
        return __('resource.dashboard');
    }

    public static function getNavigationLabel(): string
    {
        return __('resource.dashboard');
    }

    public static function canAccess(): bool
    {
        return optional(auth('admin')->user())->role === 'super-admin';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return optional(auth('admin')->user())->role === 'super-admin';
    }
}
