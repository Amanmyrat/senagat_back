<?php

namespace App\Http\Requests;

use Carbon\Carbon;
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
            'birth_date' => ['required', 'string'],

            /**
             * Passport Number
             *
             * @var string
             *
             * @example 123456
             */
            'passport_number' => ['required', 'string', 'unique:user_profiles,passport_number'],

        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();

        if (isset($data['birth_date'])) {
            // d-m-Y → Y-m-d
            $data['birth_date'] = Carbon::createFromFormat('d-m-Y', $data['birth_date'])->format('Y-m-d');
        }

        return $data;
    }
}
