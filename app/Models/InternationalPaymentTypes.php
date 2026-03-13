<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property array<array-key, mixed>|null $required_files
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentTypes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentTypes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentTypes query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentTypes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentTypes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentTypes whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentTypes whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentTypes whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentTypes whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentTypes whereRequiredFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentTypes whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentTypes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InternationalPaymentTypes extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'required_files'];

    protected $fillable = ['title', 'required_files'];

    protected $casts = [
        'required_files' => 'array',
    ];
}
