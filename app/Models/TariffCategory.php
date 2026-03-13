<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $sort
 * @property string|null $numbers
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TariffDetail> $details
 * @property-read int|null $details_count
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffCategory whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffCategory whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffCategory whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffCategory whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffCategory whereNumbers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffCategory whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffCategory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TariffCategory extends Model
{
    use HasTranslations;

    public array $translatable = ['title'];

    protected $fillable = ['title', 'numbers'];

    public function details(): HasMany
    {
        return $this->hasMany(TariffDetail::class, 'tariff_category_id');
    }
}
