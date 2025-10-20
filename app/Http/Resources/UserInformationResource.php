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
                    ->except('id')
                    ->merge(['approved' => $this->resource->profile->approved])
                : null,
            'certificates' => $this->whenLoaded('certificates', function () {
                $certificates = CertificateOrderResource::collection($this->resource->certificates)->toArray(request());

                return ! empty($certificates)
                    ? collect($certificates)->map(function ($item) {
                        return collect($item)
                            ->except(['id', 'user_id', 'profile_id', 'certificate_type_id', 'phone_number', 'home_address', 'bank_branch']);
                    })
                        ->values()
                    : null;
            }, null),
            'loans' => $this->whenLoaded('applications', function () {
                $loans = SubmitCreditDetailsResource::collection($this->resource->applications)->toArray(request());

                return ! empty($loans)
                    ? collect($loans)->map(function ($item) {
                        return collect($item)
                            ->except(['id', 'user_id', 'profile_id', 'credit_id', 'term', 'interest']);
                    })
                        ->values()
                    : null;
            }, null),
        ];
    }
}
