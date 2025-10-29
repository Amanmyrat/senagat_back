<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class RejectedLoanOrder extends CreditApplication
{
    protected $table = 'credit_applications';

    protected static function booted()
    {
        static::addGlobalScope('rejected', function (Builder $builder) {
            $builder->where('status', 'rejected');
        });
    }
}
