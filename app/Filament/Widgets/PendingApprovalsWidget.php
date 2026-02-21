<?php

namespace App\Filament\Widgets;

use App\Filament\Clusters\CardOrders\Resources\PendingCardOrderResource;
use App\Filament\Clusters\CertificateOrder\Resources\PendingCertificateOrderResource;
use App\Filament\Clusters\CreditApplication\Resources\PendingLoanOrdersResource;
use App\Filament\Resources\PendingProfileResource;
use App\Models\CardOrder;
use App\Models\CertificateOrder;
use App\Models\CreditApplication;
use App\Models\UserProfile;
use Filament\Widgets\Widget;

class PendingApprovalsWidget extends Widget
{
    /** @phpstan-ignore-next-line */
    protected static string $view = 'filament.widgets.pending-approvals-widget';

    protected static ?int $sort = 0;

    protected int|string|array $columnSpan = 'full';

    public function getPendingData(): array
    {
        $data = [
            [
                'label' => __('resource.pending_profiles'),
                'count' => UserProfile::where('approved', 'pending')->count(),
                'icon' => 'heroicon-o-user-circle',
                'color' => 'warning',
                'url' => PendingProfileResource::getUrl('index'),
            ],
            [
                'label' => __('navigation.pending_card_orders'),
                'count' => CardOrder::where('status', 'pending')->count(),
                'icon' => 'heroicon-o-credit-card',
                'color' => 'primary',
                'url' => PendingCardOrderResource::getUrl('index'),
            ],
            [
                'label' => __('navigation.pending_loan_orders'),
                'count' => CreditApplication::where('status', 'pending')->count(),
                'icon' => 'heroicon-o-banknotes',
                'color' => 'success',
                'url' => PendingLoanOrdersResource::getUrl('index'),
            ],
            [
                'label' => __('navigation.pending_certificate_orders'),
                'count' => CertificateOrder::where('status', 'pending')->count(),
                'icon' => 'heroicon-o-document-check',
                'color' => 'info',
                'url' => PendingCertificateOrderResource::getUrl('index'),
            ],
        ];

        // Only return items that have pending counts > 0
        return array_filter($data, fn ($item) => $item['count'] > 0);
    }

    public function isHidden(): bool
    {
        // Hide widget if no pending items
        return empty($this->getPendingData());
    }
}
