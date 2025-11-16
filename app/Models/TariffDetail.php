<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class TariffDetail extends Model
{
    use HasTranslations;

    public array $translatable = ['details',];
    protected $fillable=[ 'tariff_category_id',
        'number',
        'details',];
    protected $casts=['details'=> 'array'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(TariffCategory::class, 'tariff_category_id');
    }

}
