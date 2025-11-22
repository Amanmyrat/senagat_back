<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

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
