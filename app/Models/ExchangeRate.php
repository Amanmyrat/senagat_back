<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ExchangeRate extends Model
{
    use HasTranslations;

    public array $translatable = ['currency'];

    protected $fillable = ['currency', 'purchase', 'sale', 'flag'];

    protected $appends = ['flag_path'];

    public function getFlagPathAttribute(): ?string
    {
        return $this->flag
            ? asset('storage/'.$this->flag)
            : null;
    }
}
