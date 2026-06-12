<?php

namespace App\Http\Resources;

use App\Traits\DateFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardOrderResource extends JsonResource
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

            'card_title' => $this->resource->cardType?->getTranslation('title', $locale) ?? '----',
            'card_price' => $this->resource->cardType ? (float) $this->resource->cardType->price : 0,
            'bank_branch' => $this->resource->branch?->getTranslation('name', $locale) ?? '----',
            'delivery' => (bool) $this->resource->delivery,
            'status' => $this->resource->status,
            'rejected_text' => $this->resource->rejection_reasons ?? null,
            'payment_status' => $paymentRequest?->payment_status ?? 'not_required',
            'created_at' => $this->formatDateLocalized($this->resource->created_at),
        ];

        if (! $this->isHistory) {
            $data = array_merge([
                'id' => $this->resource->id,
                'work_position' => $this->resource->work_position,
                'work_phone' => $this->resource->work_phone,
                'internet_service' => (bool) $this->resource->internet_service,
                'email' => $this->resource->email,
            ], $data);
        }

        return $data;


    }
}
