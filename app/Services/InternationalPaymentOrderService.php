<?php
namespace App\Services;

use App\Enum\ErrorMessage;
use App\Models\InternationalPaymentOrder;

class InternationalPaymentOrderService
{
    /**
     * Create International Payment Order
     *
     * @param array $data Validated request data
     * @param \App\Models\User $user
     */
    public function create(array $data, $user): InternationalPaymentOrder
    {
        $profile = $user->profile ?? throw new \Exception(ErrorMessage::USER_PROFILE_REQUIRED->value);

        $type = \App\Models\InternationalPaymentTypes::findOrFail($data['payment_type_id']);

        $requiredTitles = collect($type->required_files)->pluck('title')->toArray();

        $uploadedKeys = array_keys($data['uploaded_files'] ?? []);

        foreach ($requiredTitles as $title) {
            if (! in_array($title, $uploadedKeys)) {
                throw new \Exception("File '{$title}' is required.");
            }
        }

        $storedFiles = [];
        foreach ($data['uploaded_files'] as $title => $file) {
            $storedFiles[$title] = $file->store('international_orders', 'public');

        }

        return InternationalPaymentOrder::create([
            'user_id'        => $user->id,
            'profile_id'     => $profile->id,
            'payment_type_id'=> $data['payment_type_id'],
            'branch_id'      => $data['branch_id'],
            'uploaded_files' => $storedFiles,
        ]);
    }

}
