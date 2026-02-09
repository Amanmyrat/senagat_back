<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();
        $pdfPath = fn ($file) => $file ? '/storage/'.$file : null;

        $pdfFile = match ($locale) {
            'en' => $pdfPath($this->resource->pdf_file_en),
            'ru' => $pdfPath($this->resource->pdf_file_ru),
            default => $pdfPath($this->resource->pdf_file_tk),
        };

        return [
            'id' => $this->resource->id,
            'title' => $this->resource->getTranslation('title', $locale),
            'pdf_file' => $pdfFile,
            'pdf_files' => [
                'tk' => $pdfPath($this->resource->pdf_file_tk),
                'en' => $pdfPath($this->resource->pdf_file_en),
                'ru' => $pdfPath($this->resource->pdf_file_ru),
            ],
        ];
    }
}
