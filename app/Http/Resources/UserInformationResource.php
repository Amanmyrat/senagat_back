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
                    ->merge(['status' => $this->resource->profile->approved])
                : null,
            'certificates' => $this->whenLoaded('certificates', function () {
                $certificates = CertificateOrderResource::collection($this->resource->certificates)->toArray(request());

                return ! empty($certificates)
                    ? collect($certificates)->map(function ($item) {
                        return collect($item)
                            ->except(['id', 'user_id', 'profile_id', 'certificate_type_id', 'phone_number', 'home_address']);
                    })
                        ->values()
                    : null;
            }, null),
            'loans' => $this->whenLoaded('applications', function () {
                $loans = LoanOrderResource::collection($this->resource->applications)->toArray(request());

                return ! empty($loans)
                    ? collect($loans)->map(function ($item) {
                        return collect($item)
                            ->except(['id', 'user_id', 'profile_id', 'credit_id', 'term', 'interest', 'role', 'workplace', 'bank_branch_id', 'position', 'manager_work_address', 'phone_number', 'salary', 'patent_number', 'registration_number', 'work_address']);
                    })
                        ->values()
                    : null;
            }, null),
            'cards' => $this->whenLoaded('cards', function () {
                $cards = CardOrderResource::collection($this->resource->cards)->toArray(request());

                return ! empty($cards)
                    ? collect($cards)->map(function ($item) {
                        return collect($item)
                            ->except(['id', 'user_id', 'profile_id', 'card_type_id', 'phone_number', 'bank_branch_id', 'work_position', 'work_phone', 'internet_service', 'email']);
                    })
                        ->values()
                    : null;
            }, null),
        ];
    }
}
