<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class PendingCertificateOrder extends CertificateOrder
{
    protected $table = 'certificate_orders';

    protected static function booted()
    {
        static::addGlobalScope('pending', function (Builder $builder) {
            $builder->where('status', 'pending');
        });
    }
}
