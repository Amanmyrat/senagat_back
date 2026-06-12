<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInformationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'phone' => $this->resource->phone,
            'profile' => $this->resource->profile
                ? collect((new UserProfileResource($this->resource->profile))->toArray($request))
                    ->except(['id', 'gender'])
                    ->merge(['status' => $this->resource->profile->approved,
                        'rejected_text' => $this->resource->profile->rejection_reasons,
                        ])
                : null,

            'certificates' => $this->whenLoaded('certificates', function () {
                $collection = CertificateOrderResource::collection($this->resource->certificates);
                $collection->each(function ($resource) {
                    $resource->asHistory();
                });

                return $collection;
            }, null),
            'loans' => $this->whenLoaded('applications', function () {
                $loans = LoanOrderResource::collection($this->resource->applications)->toArray(request());

                return ! empty($loans)
                    ? collect($loans)->map(function ($item) {
                        return collect($item)
                            ->except(['id', 'user_id', 'profile_id', 'credit_id', 'term', 'interest', 'role', 'workplace', 'bank_branch_id', 'position', 'manager_work_address', 'phone_number', 'salary', 'patent_number', 'registration_number', 'work_address'])
                            ->merge([
                                'rejected_text' => $item['rejected_text'] ?? null,
                            ]);
                    })
                        ->values()
                    : null;
            }, null),
           'cards' => $this->whenLoaded('cards', function () {
        $collection = CardOrderResource::collection($this->resource->cards);
        $collection->each(function ($resource) {
            $resource->asHistory();
        });
        return $collection;
    }, null),
        ];
    }
}
