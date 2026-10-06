<?php

namespace App\Models;

use App\Traits\HasActiveFlag;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

/**
 * @property string|null $image_url
 * @property string|null $background_color
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property array<array-key, mixed> $main_title
 * @property array<array-key, mixed> $description
 * @property array<array-key, mixed> $advantages
 * @property array<array-key, mixed> $header_text
 * @property array<array-key, mixed> $footer_text
 * @property array<array-key, mixed> $tariff_details
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property array<array-key, mixed>|null $sub_title
 * @property int|null $sort
 * @property-read string|null $image_path
 * @property-read mixed $translations
 *
 * @method static Builder<static>|MoneyTransfer newModelQuery()
 * @method static Builder<static>|MoneyTransfer newQuery()
 * @method static Builder<static>|MoneyTransfer query()
 * @method static Builder<static>|MoneyTransfer whereAdvantages($value)
 * @method static Builder<static>|MoneyTransfer whereBackgroundColor($value)
 * @method static Builder<static>|MoneyTransfer whereCreatedAt($value)
 * @method static Builder<static>|MoneyTransfer whereDescription($value)
 * @method static Builder<static>|MoneyTransfer whereFooterText($value)
 * @method static Builder<static>|MoneyTransfer whereHeaderText($value)
 * @method static Builder<static>|MoneyTransfer whereId($value)
 * @method static Builder<static>|MoneyTransfer whereImageUrl($value)
 * @method static Builder<static>|MoneyTransfer whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|MoneyTransfer whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|MoneyTransfer whereLocale(string $column, string $locale)
 * @method static Builder<static>|MoneyTransfer whereLocales(string $column, array $locales)
 * @method static Builder<static>|MoneyTransfer whereMainTitle($value)
 * @method static Builder<static>|MoneyTransfer whereSort($value)
 * @method static Builder<static>|MoneyTransfer whereSubTitle($value)
 * @method static Builder<static>|MoneyTransfer whereTariffDetails($value)
 * @method static Builder<static>|MoneyTransfer whereTitle($value)
 * @method static Builder<static>|MoneyTransfer whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class MoneyTransfer extends Model
{
    use HasActiveFlag;
    use HasFactory;
    use HasTranslations;

    public array $translatable = [
        'title',
        'sub_title',
        'main_title',
        'description',
        'advantages',
        'header_text',
        'footer_text',
        'tariff_details',
    ];

    protected $fillable = [
        'title',
        'sub_title',
        'main_title',
        'description',
        'advantages',
        'header_text',
        'footer_text',
        'tariff_details',
        'background_color',
        'image_url',
        'is_active',
    ];

    protected $casts = [
        'advantages' => 'array',
        'tariff_details' => 'array',
        'is_active' => 'boolean',
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute(): ?string
    {
        return $this->image_url
            ? asset('storage/'.$this->image_url)
            : null;
    }
}
