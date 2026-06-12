<?php

namespace App\Http\Resources;

use App\Traits\DateFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificateOrderResource extends JsonResource
{
    use DateFormatTrait;
    protected bool $isHistory = false;

    public function asHistory(): self
    {
        $this->isHistory = true;
        return $this;
    }

    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();
        $paymentRequest = $this->resource->paymentRequest;
        $data = [

            'certificate_name' => $this->resource->certificateType?->title ?? '----',
            'bank_branch' => $this->resource->branch?->getTranslation('name', $locale) ?? '----',
            'certificate_price' => $this->resource->certificateType?->price ?? 0,
            'status' => $this->resource->status,
            'rejected_text' => $this->resource->rejection_reasons ?? null,
            'payment_status' => $paymentRequest?->payment_status ?? '----',
            'created_at' => $this->formatDateLocalized($this->resource->created_at),
        ];


        if (! $this->isHistory) {
            $data = array_merge([
                'id' => $this->resource->id,
                'home_address' => $this->resource->home_address,

            ], $data);
        }

        return $data;
    }

}
