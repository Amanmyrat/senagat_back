<?php

namespace App\Enum;

enum RequirementType: string
{
    case Borrower = 'borrower';
    case CoBorrower = 'co_borrower';

    public function label(): string
    {
        return match($this) {
            self::Borrower => __('Borrower'),
            self::CoBorrower => __('Co-borrower'),
        };
    }
}
