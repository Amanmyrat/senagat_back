<?php

namespace App\Enum;

enum AdminRole: string
{
    case SUPER_ADMIN = 'super-admin';
    case OPERATOR = 'operator';
    case ADMIN = 'admin';
    case COMPLAINT = 'complaint';
    case INT_PAYMENT = 'int_payment';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::OPERATOR => 'Operator',
            self::ADMIN => 'Admin',
            self::COMPLAINT=>'Complaint',
            self::INT_PAYMENT=>'Int_payment'
        };
    }
}
