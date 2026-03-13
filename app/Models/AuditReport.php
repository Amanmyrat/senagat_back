<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property string|null $pdf_file_tk
 * @property string|null $pdf_file_en
 * @property string|null $pdf_file_ru
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $sort
 * @property-read string|null $pdf_file_en_path
 * @property-read string|null $pdf_file_ru_path
 * @property-read string|null $pdf_file_tk_path
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport wherePdfFileEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport wherePdfFileRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport wherePdfFileTk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditReport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AuditReport extends Model
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = ['title'];

    protected $fillable = [
        'title',
        'pdf_file_tk',
        'pdf_file_en',
        'pdf_file_ru',
    ];

    protected $appends = ['pdf_file_tk_path', 'pdf_file_en_path', 'pdf_file_ru_path'];

    public function getPdfFileTkPathAttribute(): ?string
    {
        return $this->pdf_file_tk
            ? asset('storage/'.$this->pdf_file_tk)
            : null;
    }

    public function getPdfFileEnPathAttribute(): ?string
    {
        return $this->pdf_file_en
            ? asset('storage/'.$this->pdf_file_en)
            : null;
    }

    public function getPdfFileRuPathAttribute(): ?string
    {
        return $this->pdf_file_ru
            ? asset('storage/'.$this->pdf_file_ru)
            : null;
    }
}
