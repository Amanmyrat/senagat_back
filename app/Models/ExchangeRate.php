<?php

namespace App\Models;

use App\Traits\HasActiveFlag;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $currency
 * @property string $flag
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $sort
 * @property string|null $purchase
 * @property string|null $sale
 * @property-read string|null $flag_path
 * @property-read mixed $translations
 *
 * @method static Builder<static>|ExchangeRate newModelQuery()
 * @method static Builder<static>|ExchangeRate newQuery()
 * @method static Builder<static>|ExchangeRate query()
 * @method static Builder<static>|ExchangeRate whereCreatedAt($value)
 * @method static Builder<static>|ExchangeRate whereCurrency($value)
 * @method static Builder<static>|ExchangeRate whereFlag($value)
 * @method static Builder<static>|ExchangeRate whereId($value)
 * @method static Builder<static>|ExchangeRate whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|ExchangeRate whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|ExchangeRate whereLocale(string $column, string $locale)
 * @method static Builder<static>|ExchangeRate whereLocales(string $column, array $locales)
 * @method static Builder<static>|ExchangeRate wherePurchase($value)
 * @method static Builder<static>|ExchangeRate whereSale($value)
 * @method static Builder<static>|ExchangeRate whereSort($value)
 * @method static Builder<static>|ExchangeRate whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class ExchangeRate extends Model
{
    use HasActiveFlag;
    use HasTranslations;

    public array $translatable = ['currency'];

    protected $fillable = ['currency', 'purchase', 'sale', 'flag', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['flag_path'];

    public function getFlagPathAttribute(): ?string
    {
        return $this->flag
            ? asset('storage/'.$this->flag)
            : null;
    }
}
