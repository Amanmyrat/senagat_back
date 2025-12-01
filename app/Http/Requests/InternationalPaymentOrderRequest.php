<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InternationalPaymentOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            /**
             * Payment Type
             *
             * @var int
             * @example 1
             */
            'payment_type_id' => [
                'required',
                'integer',
                'exists:international_payment_types,id'
            ],

            /**
             * Branch
             *
             * @var int
             * @example 1
             */
            'branch_id' => [
                'required',
                'integer',
                Rule::exists('locations', 'id')->where(fn ($q) => $q->where('type', 'Branch')),
            ],

            /**
             * Uploaded Files
             *
             * @var array
             */
            'uploaded_files' => [
                'required',
                'array',
                'min:1'
            ],

            /**
             * Each file
             *
             * @var \Illuminate\Http\UploadedFile
             */
            'uploaded_files.*' => [
                'file',
                'max:10240',
                'mimes:pdf,png,jpeg,jpg',
            ],
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'payment_type_id.required' => 'Payment type is required.',
            'payment_type_id.integer' => 'Payment type must be a valid ID.',
            'payment_type_id.exists' => 'Selected payment type does not exist.',

            'branch_id.required' => 'Branch is required.',
            'branch_id.integer' => 'Branch must be a valid ID.',
            'branch_id.exists' => 'Selected branch does not exist or is not a valid branch.',

            'uploaded_files.required' => 'You must upload at least one file.',
            'uploaded_files.array' => 'Uploaded files must be an array.',
            'uploaded_files.min' => 'You must upload at least one file.',

            'uploaded_files.*.file' => 'Each uploaded item must be a valid file.',
            'uploaded_files.*.max' => 'Each file cannot exceed 10MB in size.',
        ];
    }
}
