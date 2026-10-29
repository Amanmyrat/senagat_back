<?php

namespace App\Http\Requests;

use App\Enum\ErrorMessage;
use App\Models\UserProfile;
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
            'first_name' => $userHasProfile ? ['sometimes', 'string'] : ['required', 'string'],

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
             * @example I-AH 123456
             */
            'passport_number' => $userHasProfile
                ? ['sometimes', 'string', 'regex:/^(I|II|III|IV)-(AŞ|AH|MR|LB|DZ|BN)\s?[0-9]+$/i']
                : ['required', 'string', 'regex:/^(I|II|III|IV)-(AŞ|AH|MR|LB|DZ|BN)\s?[0-9]+$/i'],
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
        ] + $this->passportScanRules($userHasProfile);
    }

    /**
     * Old apps send one file as scan_passport.
     * New apps send up to 4 files as scan_passports[] or scan_passport[].
     *
     * @return array<string, mixed>
     */
    private function passportScanRules(bool $userHasProfile): array
    {
        $fileRules = ['file', 'mimes:pdf,jpg,jpeg,png', 'max:15000'];
        $limit = 'max:'.UserProfile::MAX_PASSPORT_SCANS;
        $sendsList = $this->has('scan_passports')
            || $this->hasFile('scan_passports')
            || is_array($this->file('scan_passport'));
        $presence = ($userHasProfile || $sendsList) ? 'sometimes' : 'required';

        $passportList = $this->file('scan_passports');
        if ($passportList && ! is_array($passportList)) {
            $listRules = [
                'scan_passports' => array_merge([$userHasProfile ? 'sometimes' : 'required'], $fileRules),
            ];
        } else {
            $listRules = [
                /**
                 * Passport pages, up to 4. pdf, jpg, jpeg, or png.
                 *
                 * @var array<int, string>
                 */
                'scan_passports' => ['sometimes', 'array', 'min:1', $limit],
                'scan_passports.*' => $fileRules,
            ];
        }

        if (is_array($this->file('scan_passport'))) {
            $passportRules = [
                'scan_passport' => [$presence, 'array', 'min:1', $limit],
                'scan_passport.*' => $fileRules,
            ];
        } else {
            $passportRules = [
                /**
                 * One passport file. pdf, jpg, jpeg, or png.
                 *
                 * @var string
                 *
                 * @example file
                 */
                'scan_passport' => array_merge([$presence], $fileRules),
            ];
        }

        return $listRules + $passportRules;
    }

    public function messages(): array
    {
        $listUpload = $this->has('scan_passports')
            || $this->hasFile('scan_passports')
            || is_array($this->file('scan_passport'));

        $messages = [
            'scan_passport.file' => ErrorMessage::SCAN_PASSPORT_FILE->value,
            'scan_passport.mimes' => ErrorMessage::SCAN_PASSPORT_INVALID->value,
            'scan_passport.max' => $listUpload
                ? ErrorMessage::SCAN_PASSPORT_MAX_FILES->value
                : ErrorMessage::SCAN_PASSPORT_INVALID->value,
            'scan_passport.min' => ErrorMessage::SCAN_PASSPORT_REQUIRED->value,
            'scan_passport.*.file' => ErrorMessage::SCAN_PASSPORT_FILE->value,
            'scan_passport.*.mimes' => ErrorMessage::SCAN_PASSPORT_INVALID->value,
            'scan_passport.*.max' => ErrorMessage::SCAN_PASSPORT_INVALID->value,
            'scan_passports.required' => ErrorMessage::SCAN_PASSPORT_REQUIRED->value,
            'scan_passports.array' => ErrorMessage::SCAN_PASSPORT_FILE->value,
            'scan_passports.min' => ErrorMessage::SCAN_PASSPORT_REQUIRED->value,
            'scan_passports.max' => ErrorMessage::SCAN_PASSPORT_MAX_FILES->value,
            'scan_passports.file' => ErrorMessage::SCAN_PASSPORT_FILE->value,
            'scan_passports.mimes' => ErrorMessage::SCAN_PASSPORT_INVALID->value,
            'scan_passports.*.file' => ErrorMessage::SCAN_PASSPORT_FILE->value,
            'scan_passports.*.mimes' => ErrorMessage::SCAN_PASSPORT_INVALID->value,
            'scan_passports.*.max' => ErrorMessage::SCAN_PASSPORT_INVALID->value,
            'home_phone.integer' => ErrorMessage::HOME_PHONE_INTEGER->value,
            'birth_date.date_format' => ErrorMessage::BIRTH_DATE_INVALID->value,
            'issued_date.date_format' => ErrorMessage::ISSUED_DATE_INVALID->value,
            'passport_number.regex' => ErrorMessage::PASSPORT_NUMBER_REGEX->value,
        ];

        if (! $this->profileExists()) {
            $messages += [
                'first_name.required' => ErrorMessage::FIRST_NAME_REQUIRED->value,
                'last_name.required' => ErrorMessage::LAST_NAME_REQUIRED->value,
                'birth_date.required' => ErrorMessage::BIRTH_DATE_REQUIRED->value,
                'birth_date.date_format' => ErrorMessage::BIRTH_DATE_INVALID->value,
                'passport_number.required' => ErrorMessage::PASSPORT_NUMBER_REQUIRED->value,
                'issued_date.required' => ErrorMessage::ISSUED_DATE_REQUIRED->value,
                'issued_date.date_format' => ErrorMessage::ISSUED_DATE_INVALID->value,
                'issued_by.required' => ErrorMessage::ISSUED_BY_REQUIRED->value,
                'scan_passport.required' => ErrorMessage::SCAN_PASSPORT_REQUIRED->value,
                'citizenship.required' => ErrorMessage::CITIZENSHIP_REQUIRED->value,
                'home_address.required' => ErrorMessage::HOME_ADDRESS_REQUIRED->value,
            ];
        }

        return $messages;
    }

    private function profileExists(): bool
    {
        $user = auth()->user();

        return $user && $user->profile !== null;
    }
}
