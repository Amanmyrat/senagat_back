<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
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
            'payment_type_id.required' => ErrorMessage::PAYMENT_TYPE_REQUIRED->value,
            'payment_type_id.integer' => ErrorMessage::PAYMENT_TYPE_INTEGER->value,
            'payment_type_id.exists' => ErrorMessage::PAYMENT_TYPE_NOT_EXIST->value,

            'branch_id.required' => ErrorMessage::BRANCH_REQUIRED->value,
            'branch_id.integer' => ErrorMessage::BRANCH_INTEGER->value,
            'branch_id.exists' => ErrorMessage::BRANCH_NOT_EXIST->value,

            'uploaded_files.required' => ErrorMessage::UPLOADED_FILES_REQUIRED->value,
            'uploaded_files.array' => ErrorMessage::UPLOADED_FILES_ARRAY->value,
            'uploaded_files.min' => ErrorMessage::UPLOADED_FILES_MIN->value,

            'uploaded_files.*.file' => ErrorMessage::UPLOADED_FILE_ITEM->value,
            'uploaded_files.*.max' => ErrorMessage::UPLOADED_FILE_MAX->value,
        ];
    }
}
