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
        $userHasProfile = $this->profileExists();

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
            'last_name' => $userHasProfile ? ['sometimes', 'string'] : ['required', 'string'],

            /**
             * Middle Name.
             *
             * @var string
             *
             * @example Mergenovic
             */
            'middle_name' => ['nullable', 'string'],

            /**
             *  Birth Date
             *
             * @var date
             *
             * @example 24-02-1992
             */
            'birth_date' => $userHasProfile ? ['sometimes', 'date_format:d-m-Y'] : ['required', 'date_format:d-m-Y'],

            /**
             * Passport Number
             *
             * @var string
             *
             * @example 123456
             */
            'passport_number' => $userHasProfile ? ['sometimes', 'string'] : ['required', 'string'],

            /**
             * Gender
             *
             * @var string
             *
             * @example male
             */
            'gender' => $userHasProfile ? ['sometimes', 'string', 'in:male,female']
                : ['required', 'string', 'in:male,female'],

            /**
             * Issued Date
             *
             * @var string
             *
             * @example 24-02-2001
             */
            'issued_date' => $userHasProfile ? ['sometimes', 'date_format:d-m-Y'] : ['required', 'date_format:d-m-Y'],

            /**
             * Issued By
             *
             * @var string
             *
             * @example Asgabat
             */
            'issued_by' => $userHasProfile ? ['sometimes', 'string'] : ['required', 'string'],

            /**
             * Scan Passport
             *
             * @var string
             *
             * @example file
             */
            'scan_passport' => $userHasProfile ? ['sometimes', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'] : ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],

        ];
    }

    public function messages(): array
    {
        if ($this->profileExists()) {
            return [];
        }

        return [
            'first_name.required' => 'First name is required when creating a new profile.',
            'last_name.required' => 'Last name is required when creating a new profile.',
            'birth_date.required' => 'Birth date is required when creating a new profile.',
            'birth_date.date_format' => 'Birth date must be in the format DD-MM-YYYY.',
            'passport_number.required' => 'Passport number is required when creating a new profile.',
            'gender.required' => 'Gender is required when creating a new profile.',
            'gender.in' => 'Gender must be either male or female.',
            'issued_date.required' => 'Issued date is required when creating a new profile.',
            'issued_date.date_format' => 'Issued date must be in the format DD-MM-YYYY.',
            'issued_by.required' => 'Issued by is required when creating a new profile.',
            'scan_passport.required' => 'Passport scan file is required when creating a new profile.',
            'scan_passport.mimes' => 'Passport scan must be a JPG, JPEG, PNG, or PDF file.',
            'scan_passport.max' => 'Passport scan cannot be larger than 10MB.',
        ];
    }

    private function profileExists(): bool
    {
        $user = auth()->user();

        return $user && $user->profile !== null;
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();

        if ($this->hasFile('scan_passport')) {
            $file = $this->file('scan_passport');
            $fileName = uniqid().'_'.$file->getClientOriginalName();
            $data['scan_passport'] = $file->storeAs('uploads/passports', $fileName, 'public');
        }

        return $data;
    }
}
