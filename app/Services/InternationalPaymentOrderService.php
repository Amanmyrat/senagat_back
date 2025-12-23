<?php

namespace App\Services;

use App\Enum\ErrorMessage;
use App\Models\InternationalPaymentOrder;

class InternationalPaymentOrderService
{
    /**
     * Create International Payment Order
     *
     * @param  array  $data  Validated request data
     * @param  \App\Models\User  $user
     */
    public function create(array $data, $user): InternationalPaymentOrder
    {
        $profile = $user->profile ?? throw new \Exception(ErrorMessage::USER_PROFILE_REQUIRED->value);

        $type = \App\Models\InternationalPaymentTypes::findOrFail($data['payment_type_id']);

        $requiredCount = count($type->required_files);
        $uploadedFiles = $data['uploaded_files'] ?? [];
        $uploadedCount = count($uploadedFiles);
        $messageTemplate = ErrorMessage::UPLOADED_FILES_COUNT->value;
        $message = str_replace('{count}', $requiredCount, $messageTemplate);
        if ($uploadedCount !== $requiredCount) {
            throw new \Exception($message);
        }
        $storedFiles = [];
        foreach ($uploadedFiles as $file) {
            $storedFiles[] = $file->store('international_orders', 'public');
        }

        return InternationalPaymentOrder::create([
            'user_id' => $user->id,
            'profile_id' => $profile->id,
            'payment_type_id' => $data['payment_type_id'],
            'branch_id' => $data['branch_id'],
            'uploaded_files' => $storedFiles,
        ]);
    }
}
