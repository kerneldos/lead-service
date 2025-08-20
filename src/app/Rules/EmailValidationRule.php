<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailValidationRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Базовая проверка email
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail('Некорректный формат email адреса');
            return;
        }

        // Проверка на запрещенные домены
        $forbiddenDomains = [
            'example.com',
            'test.com',
            'localhost',
            '10minutemail.com',
            'tempmail.org'
        ];

        $domain = substr(strrchr($value, "@"), 1);
        if (in_array(strtolower($domain), $forbiddenDomains)) {
            $fail('Использование временных email адресов запрещено');
            return;
        }

        // Проверка на минимальную длину локальной части
        $localPart = substr($value, 0, strpos($value, '@'));
        if (strlen($localPart) < 2) {
            $fail('Локальная часть email должна содержать минимум 2 символа');
        }
    }
}
