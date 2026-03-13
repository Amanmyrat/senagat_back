<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property string|null $image_url
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property array<array-key, mixed>|null $description
 * @property string $background_color
 * @property array<array-key, mixed> $advantages
 * @property array<array-key, mixed>|null $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $sort
 * @property-read string|null $image_path
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereAdvantages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereBackgroundColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DepositType extends Model
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = ['title', 'description', 'advantages', 'details'];

    protected $fillable = ['title', 'description', 'image_url', 'background_color', 'advantages', 'details'];

    protected $casts = [
        'advantages' => 'array',
        'details' => 'array',
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute(): ?string
    {
        return $this->image_url
            ? asset('storage/'.$this->image_url)
            : null;
    }
}
