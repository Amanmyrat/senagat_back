<?php

namespace App\Models;

use App\Traits\HasActiveFlag;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int $tariff_category_id
 * @property array<array-key, mixed>|null $details
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $number
 * @property array<array-key, mixed>|null $title
 * @property int|null $sort
 * @property-read TariffCategory $category
 * @property-read mixed $translations
 *
 * @method static Builder<static>|TariffDetail newModelQuery()
 * @method static Builder<static>|TariffDetail newQuery()
 * @method static Builder<static>|TariffDetail query()
 * @method static Builder<static>|TariffDetail whereCreatedAt($value)
 * @method static Builder<static>|TariffDetail whereDetails($value)
 * @method static Builder<static>|TariffDetail whereId($value)
 * @method static Builder<static>|TariffDetail whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|TariffDetail whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|TariffDetail whereLocale(string $column, string $locale)
 * @method static Builder<static>|TariffDetail whereLocales(string $column, array $locales)
 * @method static Builder<static>|TariffDetail whereNumber($value)
 * @method static Builder<static>|TariffDetail whereSort($value)
 * @method static Builder<static>|TariffDetail whereTariffCategoryId($value)
 * @method static Builder<static>|TariffDetail whereTitle($value)
 * @method static Builder<static>|TariffDetail whereUpdatedAt($value)
 * @method static Builder<static>|TariffDetail orderByNumber(string $direction = 'asc')
 *
 * @mixin Eloquent
 */
class TariffDetail extends Model
{
    use HasActiveFlag;
    use HasTranslations;

    public array $translatable = ['title'];

    protected $fillable = ['tariff_category_id',
        'title',
        'number',
        'details',
        'is_active', ];

    protected $casts = [
        'details' => 'array',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(TariffCategory::class, 'tariff_category_id');
    }

    public function scopeOrderByNumber($query, string $direction = 'asc')
    {
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        return $query->orderByRaw(
            "string_to_array(COALESCE(NULLIF(number, ''), '0'), '.')::int[] {$direction}"
        );
    }
}
