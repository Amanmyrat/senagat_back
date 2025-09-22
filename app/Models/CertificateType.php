<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


/**
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateType whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateType whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateType whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateType whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateType wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CertificateType extends Model
{
    use HasTranslations;

    public array $translatable = ['title'];

    protected $fillable = ['title', 'price'];
}
