<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;

class UserProfileRequest extends FormRequest
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
             * First Name.
             *
             * @var string
             *
             * @example Mergen
             */
            'first_name' => ['required', 'string'],

            /**
             * Last Name.
             *
             * @var string
             *
             * @example Jumayev
             */
            'last_name' => ['required', 'string'],

            /**
             * Middle Name.
             *
             * @var string
             *
             * @example Mergenovic
             */
            'middle_name' => ['required', 'string'],

            /**
             *  Birth Date
             *
             * @var date
             *
             * @example 24-02-1992
             */
            'birth_date' => ['required', 'date_format:d-m-Y'],

            /**
             * Passport Number
             *
             * @var string
             *
             * @example 123456
             */
            'passport_number' => ['required', 'string'],

            /**
             * Gender
             *
             * @var string
             *
             * @example male
             */
            'gender' => ['required', 'string'],

            /**
             * Issued Date
             *
             * @var string
             *
             * @example 24-02-2001
             */
            'issued_date' => ['required', 'date_format:d-m-Y'],

            /**
             * Issued By
             *
             * @var string
             *
             * @example Asgabat
             */
            'issued_by' => ['required', 'string'],

            /**
             * Scan Passport
             *
             * @var string
             *
             * @example file
             */
            'scan_passport' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],

            /**
             * approved
             *
             * @var string
             *
             * @example rejected
             */
            'approved' => ['required', 'string'],

        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();

        if ($this->hasFile('scan_path')) {
            $file = $this->file('scan_path');
            $fileName = uniqid().'_'.$file->getClientOriginalName();
            $data['scan_path'] = $file->storeAs('uploads/passports', $fileName, 'public');
        }

        return $data;
    }
}
