<?php

namespace App\Models;

use App\Traits\HasActiveFlag;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $sort
 * @property string|null $numbers
 * @property-read Collection<int, TariffDetail> $details
 * @property-read int|null $details_count
 * @property-read mixed $translations
 *
 * @method static Builder<static>|TariffCategory newModelQuery()
 * @method static Builder<static>|TariffCategory newQuery()
 * @method static Builder<static>|TariffCategory query()
 * @method static Builder<static>|TariffCategory whereCreatedAt($value)
 * @method static Builder<static>|TariffCategory whereId($value)
 * @method static Builder<static>|TariffCategory whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|TariffCategory whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|TariffCategory whereLocale(string $column, string $locale)
 * @method static Builder<static>|TariffCategory whereLocales(string $column, array $locales)
 * @method static Builder<static>|TariffCategory whereNumbers($value)
 * @method static Builder<static>|TariffCategory whereSort($value)
 * @method static Builder<static>|TariffCategory whereTitle($value)
 * @method static Builder<static>|TariffCategory whereUpdatedAt($value)
 *
 * @property int|null $number
 *
 * @method static Builder<static>|TariffCategory whereNumber($value)
 *
 * @mixin Eloquent
 */
class TariffCategory extends Model
{
    use HasActiveFlag;
    use HasTranslations;

    public array $translatable = ['title'];

    protected $fillable = ['title', 'number', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(TariffDetail::class, 'tariff_category_id');
    }
}
