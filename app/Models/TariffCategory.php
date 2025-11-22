<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class TariffCategory extends Model
{
    use HasTranslations;

    public array $translatable = ['title'];

    protected $fillable = ['title','numbers'];

    public function details(): HasMany
    {
        return $this->hasMany(TariffDetail::class, 'tariff_category_id');
    }
}
