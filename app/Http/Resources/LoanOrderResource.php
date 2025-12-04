<?php

namespace App\Http\Resources;

use App\Traits\DateFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanOrderResource extends JsonResource
{
    use DateFormatTrait;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {



        $locale = app()->getLocale();
        $data = [
            'id' => $this->resource->id,
            'credit_name' => optional($this->resource->credit)->getTranslation('name', $locale),
            'term' => $this->resource->term,
            'amount' => $this->resource->amount,
            'interest' => $this->resource->interest,
            'monthly_payment' => $this->resource->monthly_payment,
            'country' => $this->resource->country,
            'bank_branch' => optional($this->resource->branch)->getTranslation('name', $locale),
            'role' => $this->resource->role,
            'status' => $this->resource->status,
            'created_at' => $this->formatDateLocalized($this->resource->created_at),

        ];

        // Rol bazlı ek alanlar
        if ($this->resource->role === 'entrepreneur') {
            $data = array_merge($data, [
                'patent_number' => $this->resource->patent_number,
                'registration_number' => $this->resource->registration_number,
                'work_address' => $this->resource->work_address,
            ]);
        }

        if ($this->resource->role === 'manager') {
            $data = array_merge($data, [
                'workplace' => $this->resource->workplace,
                'position' => $this->resource->position,
                'manager_work_address' => $this->resource->manager_work_address,
                'salary' => $this->resource->salary,
            ]);
        }

        return $data;
    }
}
