<?php

namespace Tests\Unit\Factories;

use App\DTO\AddressDTO;
use App\DTO\LeadDTO;
use App\DTO\PassportDTO;
use App\Factories\LeadFactory;
use Tests\TestCase;

class LeadFactoryTest extends TestCase
{
    private LeadFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new LeadFactory();
    }

    public function testCreatesBasicLeadFromDTO()
    {
        $dto = new LeadDTO(
            firstName: 'John',
            lastName: 'Doe',
            patronymic: null, // Added
            birthDate: null,  // Added
            phone: '+79123456789',
            email: 'john@example.com',
            amount: 10000,
            term: 12,
            passport: null, // Added
            registrationAddress: null, // Added
            residenceAddress: null, // Added
            policyAgreement: true,
            channelId: 1
        );

        $lead = $this->factory->createFromDTO($dto, false);

        $this->assertNull($lead->getId());
        $this->assertEquals(1, $lead->getChannelId());
        $this->assertFalse($lead->isFull());
        $this->assertNull($lead->getProcessedAt());
        $this->assertEquals('John', $lead->getData()['first_name']);
        $this->assertEquals('Doe', $lead->getData()['last_name']);
    }

    public function testCreatesFullLeadFromDTO()
    {
        $dto = new LeadDTO(
            firstName: 'John',
            lastName: 'Doe',
            patronymic: 'Smith',
            birthDate: '1990-01-01',
            phone: '+79123456789',
            email: 'john@example.com',
            amount: 10000,
            term: 12,
            passport: new PassportDTO(
                series: '1234',
                number: '567890',
                issuedBy: 'Police Dept',
                issuedDate: '2010-01-01',
                divisionCode: '123-456'
            ),
            registrationAddress: new AddressDTO(
                type: 'registration',
                region: 'Moscow',
                city: 'Moscow',
                street: 'Main St',
                house: '1',
                housing: null,
                flat: null
            ),
            residenceAddress: null,
            policyAgreement: true,
            channelId: 1
        );

        $lead = $this->factory->createFromDTO($dto, true);

        $this->assertTrue($lead->isFull());
        $this->assertEquals('Smith', $lead->getData()['patronymic']);
        $this->assertEquals('1234', $lead->getData()['passport']['series']);
        $this->assertEquals('Moscow', $lead->getData()['registration_address']['city']);
    }
}
