<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebhookPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->bearerToken() === config('services.payment_service.webhook_secret');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'external_id' => 'required',
            'status'      => 'required|in:confirmed,failed',
            'provider'    => 'required|string',
        ];
    }
    public function failedAuthorization()
    {
        abort(403);
    }
}
