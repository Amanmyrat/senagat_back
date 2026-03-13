<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array<array-key, mixed>|null $sub_title
 * @property int|null $sort
 * @property-read string|null $image_path
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereAdvantages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereBackgroundColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereFooterText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereHeaderText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereMainTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereSubTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereTariffDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MoneyTransfer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MoneyTransfer extends Model
{
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
    ];

    protected $casts = [
        'advantages' => 'array',
        'tariff_details' => 'array',
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute(): ?string
    {
        return $this->image_url
            ? asset('storage/'.$this->image_url)
            : null;
    }
}
