<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property string|null $image_url
 * @property string $price
 * @property array<array-key, mixed>|null $advantages
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CardCategory> $cardCategories
 * @property-read int|null $card_categories_count
 * @property-read mixed $image_path
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType whereAdvantages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CardType extends Model
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = ['title', 'advantages'];

    protected $fillable = ['category_id', 'title', 'advantages', 'image_url','price'];

    protected $casts = [
        'advantages' => 'array',

    ];


    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return $this->image_url
            ? asset('storage/'.$this->image_url)
            : null;
    }

    // Relations
    public function cardCategories(): BelongsToMany
    {
        return $this->belongsToMany(CardCategory::class, 'card_category_card_type');
    }
}
