<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TariffDetail extends Model
{
    protected $fillable=[ 'tariff_category_id',
        'number',
        'details',];
    protected $casts=['details'=> 'array'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(TariffCategory::class, 'tariff_category_id');
    }
}
