<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class ApprovedCertificateOrder extends CertificateOrder
{
    protected $table = 'certificate_orders';

    protected static function booted()
    {
        static::addGlobalScope('approved', function (Builder $builder) {
            $builder->where('status', 'approved');
        });
    }
}
