<?php

namespace App\Filament\Widgets;

use App\Models\CardOrder;
use App\Models\CertificateOrder;
use App\Models\ContactMessage;
use App\Models\CreditApplication;
use App\Models\User;
use App\Models\UserProfile;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make(__('resource.total_users'), User::count())
                ->description(__('resource.registered_users'))
                ->descriptionIcon('heroicon-o-users')
                ->color('success')
                ->chart([7, 12, 16, 18, 22, 25, 28]),

            Stat::make(__('resource.pending_profiles'), UserProfile::where('approved', 'pending')->count())
                ->description(__('resource.awaiting_approval'))
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make(__('resource.card_orders'), CardOrder::count())
                ->description(sprintf(
                    '%s: %d | %s: %d',
                    __('resource.pending'),
                    CardOrder::where('status', 'pending')->count(),
                    __('resource.approved'),
                    CardOrder::where('status', 'approved')->count()
                ))
                ->descriptionIcon('heroicon-o-credit-card')
                ->color('primary'),

            Stat::make(__('resource.loan_applications'), CreditApplication::count())
                ->description(sprintf(
                    '%s: %d | %s: %d',
                    __('resource.pending'),
                    CreditApplication::where('status', 'pending')->count(),
                    __('resource.approved'),
                    CreditApplication::where('status', 'approved')->count()
                ))
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('info'),

            Stat::make(__('resource.certificate_orders'), CertificateOrder::count())
                ->description(sprintf(
                    '%s: %d | %s: %d',
                    __('resource.pending'),
                    CertificateOrder::where('status', 'pending')->count(),
                    __('resource.approved'),
                    CertificateOrder::where('status', 'approved')->count()
                ))
                ->descriptionIcon('heroicon-o-document-check')
                ->color('success'),

            Stat::make(__('resource.contact_messages'), ContactMessage::count())
                ->description(__('resource.total_inquiries'))
                ->descriptionIcon('heroicon-o-envelope')
                ->color('danger')
                ->chart([3, 5, 8, 12, 15, 18, 20]),
        ];
    }
}
