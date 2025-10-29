<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class RejectedCertificateOrder extends CertificateOrder
{
    protected $table = 'certificate_orders';

    protected static function booted()
    {
        static::addGlobalScope('rejected', function (Builder $builder) {
            $builder->where('status', 'rejected');
        });
    }
}
