<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CardType> $cardTypes
 * @property-read int|null $card_types_count
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardCategory whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardCategory whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardCategory whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardCategory whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardCategory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CardCategory extends Model
{
    use HasTranslations;

    public array $translatable = ['title'];

    protected $fillable = [
        'title',
    ];

    public function cardTypes(): BelongsToMany
    {
        return $this->belongsToMany(CardType::class, 'card_category_card_type');
    }
}
