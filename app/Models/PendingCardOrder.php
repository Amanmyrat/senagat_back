<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class PendingCardOrder extends CardOrder
{
    protected $table = 'card_orders';

    protected static function booted()
    {
        static::addGlobalScope('pending', function (Builder $builder) {
            $builder->where('status', 'pending');
        });
    }
}
