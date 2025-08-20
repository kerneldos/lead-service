<?php

namespace Tests\Feature;

use App\Services\Contracts\LeadProcessorInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class LeadControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws Exception
     */
    public function testCreatesLeadSuccessfully()
    {
        $mockProcessor = $this->createMock(LeadProcessorInterface::class);
        $mockProcessor->expects($this->once())
            ->method('process')
            ->willReturn([
                'lead_id' => 1,
                'client_response' => ['id' => 101],
                'application_response' => ['id' => 201]
            ]);

        $this->app->instance(LeadProcessorInterface::class, $mockProcessor);

        $response = $this->postJson('/api/leads', [
            'first_name' => 'Иван', // Cyrillic
            'last_name' => 'Петров', // Cyrillic
            'birth_date' => '1990-01-01', // Added
            'phone' => '+79123456789',
            'email' => 'real@domain.com', // Non-temporary email
            'amount' => 10000,
            'term' => 12,
            'policy_agreement' => true,
            'address_registration' => [ // Added
                'region' => 'Москва',
                'city' => 'Москва',
                'street' => 'Ленина',
                'house' => '1'
            ]
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'lead_id' => 1
            ]);
    }

    public function testValidatesRequiredFields()
    {
        $response = $this->postJson('/api/leads', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'first_name', 'last_name', 'phone', 'email',
                'amount', 'term', 'policy_agreement'
            ]);
    }

    public function testValidatesEmailFormat()
    {
        $response = $this->postJson('/api/leads', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '+79123456789',
            'email' => 'invalid-email',
            'amount' => 10000,
            'term' => 12,
            'policy_agreement' => true
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
