<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UserStatus: string implements HasColor, HasLabel
{
    case Approved = 'approved';
    case Pending = 'pending';
    case Rejected = 'rejected';

    public function getLabel(): string
    {
        return match ($this) {
            self::Approved => 'approved',
            self::Pending => 'pending',
            self::Rejected => 'rejected',

        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Approved => 'success',
            self::Pending => 'warning',

            self::Rejected => 'danger',

        };
    }
}
