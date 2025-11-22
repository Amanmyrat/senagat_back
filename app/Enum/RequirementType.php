<?php

namespace App\Enum;

enum RequirementType: string
{
    case Borrower = 'borrower';
    case Guarantor = 'guarantor';
    case DomesticPersons = 'domestic_persons';
    case Payer = 'payer';
    case PrivateBusinessParties = 'private_business_parties';

    public function label(): string
    {
        return match ($this) {
            self::Borrower => __('resource.borrower'),
            self::Guarantor => __('resource.guarantor'),
            self::DomesticPersons => __('resource.domestic_person'),
            self::Payer => __('resource.payer'),
            self::PrivateBusinessParties => __('resource.private_business_parties'),
        };
    }
}
