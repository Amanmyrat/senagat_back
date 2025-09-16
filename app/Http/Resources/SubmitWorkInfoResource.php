<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmitWorkInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'role' => $this->resource->role,
        ];

        if ($this->resource->role === 'entrepreneur') {
            $data = array_merge($data, [
                'id' => $this->resource->id,
                'patent_number' => $this->resource->patent_number,
                'registration_number' => $this->resource->registration_number,
                'work_address' => $this->resource->work_address,
            ]);
        }

        if ($this->resource->role === 'manager') {
            $data = array_merge($data, [
                'id' => $this->resource->id,
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
