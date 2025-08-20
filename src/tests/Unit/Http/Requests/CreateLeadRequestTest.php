<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\CreateLeadRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CreateLeadRequestTest extends TestCase
{
    public function testValidationPassesWithValidData()
    {
        $request = new CreateLeadRequest();

        $validator = Validator::make([
            'first_name' => 'Иван', // Changed to Cyrillic
            'last_name' => 'Петров', // Changed to Cyrillic
            'phone' => '+79123456789',
            'email' => 'real@domain.com', // Changed to non-temporary email
            'amount' => 10000,
            'term' => 12,
            'policy_agreement' => true,
            'birth_date' => '1990-01-01', // Added required field
            'passport' => [
                'series' => '1234',
                'number' => '567890',
                'issued_by' => 'Police Dept',
                'issued_date' => '2010-01-01',
                'division_code' => '123-456'
            ],
            'address_registration' => [ // Added required address
                'region' => 'Москва',
                'city' => 'Москва',
                'street' => 'Ленина',
                'house' => '1'
            ]
        ], $request->rules());

        $this->assertFalse($validator->fails());
    }

    public function testValidationFailsWithInvalidEmail()
    {
        $request = new CreateLeadRequest();

        $validator = Validator::make([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '+79123456789',
            'email' => 'invalid-email',
            'amount' => 10000,
            'term' => 12,
            'policy_agreement' => true
        ], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    public function testValidationFailsWithTestValues()
    {
        $request = new CreateLeadRequest();

        $validator = Validator::make([
            'first_name' => 'test',
            'last_name' => 'Doe',
            'phone' => '+79123456789',
            'email' => 'john@example.com',
            'amount' => 10000,
            'term' => 12,
            'policy_agreement' => true
        ], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('first_name', $validator->errors()->toArray());
    }
}
