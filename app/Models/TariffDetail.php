<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int $tariff_category_id
 * @property array<array-key, mixed>|null $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $number
 * @property array<array-key, mixed>|null $title
 * @property int|null $sort
 * @property-read \App\Models\TariffCategory $category
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail whereTariffCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TariffDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TariffDetail extends Model
{
    use HasTranslations;

    public array $translatable = ['title'];

    protected $fillable = ['tariff_category_id',
        'title',
        'number',
        'details', ];

    protected $casts = ['details' => 'array'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(TariffCategory::class, 'tariff_category_id');
    }
}
