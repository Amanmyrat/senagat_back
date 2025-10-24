<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UserStatus: string implements HasColor, HasLabel
{
    case Approved = 'approved';
    case Pending = 'pending';
    case Rejected = 'rejected';
    case Draft = 'draft';

    public function getLabel(): string
    {
        return match ($this) {
            self::Approved => __('resource.approved'),
            self::Pending => __('resource.pending'),
            self::Rejected => __('resource.rejected'),
            self::Draft => __('resource.draft')

        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Approved => 'success',
            self::Pending => 'warning',
            self::Draft => 'secondary',
            self::Rejected => 'danger',

        };
    }
}
