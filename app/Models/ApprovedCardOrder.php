<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class ApprovedCardOrder extends CardOrder
{
    protected $table = 'card_orders';

    protected static function booted()
    {
        static::addGlobalScope('approved', function (Builder $builder) {
            $builder->where('status', 'approved');
        });
    }
}
