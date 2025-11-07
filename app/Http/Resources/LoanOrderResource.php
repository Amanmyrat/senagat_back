<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'profile_id' => $this->resource->profile_id,
            'credit_id' => $this->resource->credit_id,
            'credit_name' => optional($this->resource->credit)->name,
            'term' => $this->resource->term,
            'amount' => $this->resource->amount,
            'interest' => $this->resource->interest,
            'monthly_payment' => $this->resource->monthly_payment,
            'country' => $this->resource->country,
            'bank_branch_id' => $this->resource->bank_branch_id,
            'role' => $this->resource->role,
            'status' => $this->resource->status,
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
                'phone_number' => $this->resource->phone_number,
                'salary' => $this->resource->salary,
            ]);
        }

        return $data;
    }
}
