<?php

namespace App\Providers\Filament;

use App\Filament\Auth\CustomLogin;
use App\Http\Middleware\RedirectIfNotSuperAdmin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Kenepa\TranslationManager\TranslationManagerPlugin;

class AdminPanelProvider extends PanelProvider
{
    public static function getHomeUrlForRole(?string $role): string
    {
        return match ($role) {
            'super-admin'        => '/admin',
            'operator','credit-card-viewer'=> '/admin/card-orders/card-orders',
            'certificate-viewer' => '/admin/certificate-order',
            'loan-viewer'        => '/admin/credit-application/loan-orders',
            default              => '/admin/card-orders',
        };
    }
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->homeUrl(fn () => self::getHomeUrlForRole(auth('admin')->user()?->role))
            ->login(CustomLogin::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([

            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                RedirectIfNotSuperAdmin::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->font('System', provider: 'App\\Filament\\FontProviders\\LocalFontProvider')
            ->defaultAvatarProvider('App\\Filament\\AvatarProviders\\LocalAvatarProvider')
            ->plugins([

                SpatieLaravelTranslatablePlugin::make()->defaultLocales(['tk', 'en', 'ru']),
                TranslationManagerPlugin::make(),
            ])
            ->authGuard('admin');
    }
}
