<?php

namespace App\Http\Resources;

use App\Traits\DateFormatTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificateOrderResource extends JsonResource
{
    use DateFormatTrait;

    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();
        return [


            'id' => $this->resource->id,
            'certificate_name' => optional($this->resource->certificateType)->title,
            'home_address' => $this->resource->home_address,
            'bank_branch' => optional($this->resource->branch)->getTranslation('name', $locale),
            'certificate_price' => $this->resource->certificateType->price,
            'status' => $this->resource->status,
            'created_at' => $this->formatDateLocalized($this->resource->created_at),
        ];
    }

}
