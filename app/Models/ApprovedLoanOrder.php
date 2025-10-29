<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class ApprovedLoanOrder extends CreditApplication
{
    protected $table = 'credit_applications';

    protected static function booted()
    {
        static::addGlobalScope('approved', function (Builder $builder) {
            $builder->where('status', 'approved');
        });
    }
}
