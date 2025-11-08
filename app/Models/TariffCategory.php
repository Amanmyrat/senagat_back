<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TariffCategory extends Model
{
    protected $fillable =['title'];

    public function details(): HasMany
    {
        return $this->hasMany(TariffDetail::class, 'tariff_category_id');
    }

}
