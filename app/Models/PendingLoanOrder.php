<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class PendingLoanOrder extends CreditApplication
{
    protected $table = 'credit_applications';

    protected static function booted()
    {
        static::addGlobalScope('pending', function (Builder $builder) {
            $builder->where('status', 'pending');
        });
    }
}
