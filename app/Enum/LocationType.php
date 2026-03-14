<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum LocationType: string implements HasColor, HasLabel
{
    case ATM = 'ATM';
    case BRANCH = 'Branch';

    public function getLabel(): string
    {
        return match ($this) {
            self::ATM => __('resource.atm'),
            self::BRANCH => __('resource.branch'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::ATM => 'success',
            self::BRANCH => 'warning',
        };
    }
}
