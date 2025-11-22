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

        // Get the appropriate PDF file based on locale
        $pdfFile = match ($locale) {
            'en' => $this->resource->pdf_file_en
                ? asset('storage/'.$this->resource->pdf_file_en)
                : null,
            'ru' => $this->resource->pdf_file_ru
                ? asset('storage/'.$this->resource->pdf_file_ru)
                : null,
            default => $this->resource->pdf_file_tk
                ? asset('storage/'.$this->resource->pdf_file_tk)
                : null,
        };

        return [
            'id' => $this->resource->id,
            'title' => $this->resource->getTranslation('title', $locale),
            'pdf_file' => $pdfFile,
            'pdf_files' => [
                'tk' => $this->resource->pdf_file_tk
                    ? asset('storage/'.$this->resource->pdf_file_tk)
                    : null,
                'en' => $this->resource->pdf_file_en
                    ? asset('storage/'.$this->resource->pdf_file_en)
                    : null,
                'ru' => $this->resource->pdf_file_ru
                    ? asset('storage/'.$this->resource->pdf_file_ru)
                    : null,
            ],
        ];
    }
}
