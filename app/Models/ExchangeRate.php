<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $currency
 * @property string $flag
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $sort
 * @property string|null $purchase
 * @property string|null $sale
 * @property-read string|null $flag_path
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate wherePurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
