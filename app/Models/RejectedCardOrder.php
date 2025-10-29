<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class RejectedCardOrder extends CardOrder
{
    protected $table = 'card_orders';

    protected static function booted()
    {
        static::addGlobalScope('rejected', function (Builder $builder) {
            $builder->where('status', 'rejected');
        });
    }
}
