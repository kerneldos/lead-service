<?php

namespace App\Http\Requests;

use App\Rules\EmailValidationRule;
use App\Rules\PhoneValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateLeadRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[А-ЯЁа-яё\-\s]+$/u', // Только кириллица, дефисы и пробелы
                'not_regex:/тест|test/i' // Запрет тестовых значений
            ],

            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[А-ЯЁа-яё\-\s]+$/u',
                'not_regex:/тест|test/i'
            ],

            'patronymic' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[А-ЯЁа-яё\-\s]*$/u', // Может быть пустым
                'not_regex:/тест|test/i'
            ],

            'birth_date' => ['required', 'date', 'before:' . date('Y-m-d', strtotime('-18 years'))],

            'phone' => ['required', 'string', new PhoneValidationRule()],
            'email' => ['required', 'email', new EmailValidationRule()],

            'amount' => [
                'required',
                'numeric',
                'min:1000', // Минимальная сумма
                'max:1000000' // Максимальная сумма
            ],
            'term' => [
                'required',
                'integer',
                'min:3', // Минимальный срок
                'max:60' // Максимальный срок
            ],

            'policy_agreement' => [
                'required',
                'boolean',
                'accepted' // Должно быть true
            ],

            'channel_id' => 'sometimes|integer',

            'passport' => ['nullable', 'array'],
            'passport.series' => [
                'required_with:passport',
                'string',
                'size:4',
                'regex:/^[0-9]{4}$/',
                'not_in:0000,1111,2222,3333,4444,5555,6666,7777,8888,9999'
            ],
            'passport.number' => [
                'required_with:passport',
                'string',
                'size:6',
                'regex:/^[0-9]{6}$/',
                'not_in:000000,111111,222222,333333,444444,555555,666666,777777,888888,999999,123456,012345'
            ],
            'passport.issued_by' => ['required_with:passport', 'string', 'max:500'],
            'passport.issued_date' => ['required_with:passport', 'date', 'before:today'],
            'passport.division_code' => ['required_with:passport', 'string', 'regex:/^\d{3}-\d{3}$/'],

            'address_registration' => ['nullable', 'array'],
            'address_registration.region' => ['required_with:address_registration', 'string', 'max:255', 'not_regex:/тест|test/i'],
            'address_registration.city' => ['required_with:address_registration', 'string', 'max:255', 'not_regex:/тест|test/i'],
            'address_registration.street' => ['required_with:address_registration', 'string', 'max:255', 'not_regex:/тест|test/i'],
            'address_registration.house' => ['required_with:address_registration', 'string', 'max:255', 'not_regex:/тест|test/i'],
            'address_registration.housing' => ['nullable', 'string', 'max:50'],
            'address_registration.flat' => ['nullable', 'string', 'max:50'],

            'address_residence' => ['nullable', 'array'],
            'address_residence.region' => ['required_with:address_residence', 'string', 'max:255'],
            'address_residence.city' => ['required_with:address_residence', 'string', 'max:255'],
            'address_residence.street' => ['required_with:address_residence', 'string', 'max:255'],
            'address_residence.house' => ['required_with:address_residence', 'string', 'max:50'],
            'address_residence.housing' => ['nullable', 'string', 'max:50'],
            'address_residence.flat' => ['nullable', 'string', 'max:50'],
        ];
    }

    /**
     * @param Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator): mixed
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
