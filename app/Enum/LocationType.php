<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum LocationType: string implements HasLabel, HasColor
{
    case ATM = 'ATM';
    case BRANCH = 'Branch';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ATM => 'ATM',
            self::BRANCH => 'Branch',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ATM => 'success',
            self::BRANCH => 'warning',
        };
    }
}
