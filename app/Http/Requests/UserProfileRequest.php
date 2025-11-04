<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
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

            /**
              'home_address'
             * Citizenship
             *
             * @var string
             *
             * @example Turkmenistan
             */
            'citizenship' => $userHasProfile ? ['sometimes', 'string'] : ['required', 'string'],
            /**
             * Home phone
             *
             * @var int
             *
             * @example 12525355
             */
            'home_phone' => ['nullable', 'integer'],
            /**
             * Home Address
             *
             * @var string
             *
             * @example Aşgabat ş. Büzmeýin etrap
             */
            'home_address' => $userHasProfile ? ['sometimes', 'string'] : ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        if ($this->profileExists()) {
            return [];
        }

        return [
            'first_name.required' => ErrorMessage::FIRST_NAME_REQUIRED->value,
            'last_name.required' => ErrorMessage::LAST_NAME_REQUIRED->value,
            'birth_date.required' => ErrorMessage::BIRTH_DATE_REQUIRED->value,
            'birth_date.date_format' => ErrorMessage::BIRTH_DATE_INVALID->value,
            'passport_number.required' => ErrorMessage::PASSPORT_NUMBER_REQUIRED->value,
            'gender.required' => ErrorMessage::GENDER_REQUIRED->value,
            'gender.in' => ErrorMessage::GENDER_INVALID->value,
            'issued_date.required' => ErrorMessage::ISSUED_DATE_REQUIRED->value,
            'issued_date.date_format' => ErrorMessage::ISSUED_DATE_INVALID->value,
            'issued_by.required' => ErrorMessage::ISSUED_BY_REQUIRED->value,
            'scan_passport.required' => ErrorMessage::SCAN_PASSPORT_REQUIRED->value,
            'scan_passport.mimes' => ErrorMessage::SCAN_PASSPORT_INVALID->value,
            'scan_passport.max' => ErrorMessage::SCAN_PASSPORT_INVALID->value,
            'citizenship.required' => ErrorMessage::CITIZENSHIP_REQUIRED->value,
            'home_address.required' => ErrorMessage::HOME_ADDRESS_REQUIRED->value,
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
