<?php

namespace Tests\Unit\Services;

use App\DTO\AddressDTO;
use App\DTO\LeadDTO;
use App\DTO\PassportDTO;
use App\Services\LeadCompletenessChecker;
use Tests\TestCase;

class LeadCompletenessCheckerTest extends TestCase
{
    private LeadCompletenessChecker $checker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->checker = new LeadCompletenessChecker();
    }

    public function testIdentifiesCompleteLead()
    {
        $dto = new LeadDTO(
            firstName: 'Иван',
            lastName: 'Петров',
            patronymic: 'Иванович',
            birthDate: '1990-01-01',
            phone: '+79123456789',
            email: 'real@domain.com',
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
                region: 'Москва',
                city: 'Москва',
                street: 'Ленина',
                house: '1',
                housing: null,
                flat: null
            ),
            residenceAddress: null,
            policyAgreement: true,
            channelId: 1
        );

        $this->assertTrue($this->checker->isComplete($dto));
    }

    public function testIdentifiesIncompleteLead()
    {
        $dto = new LeadDTO(
            firstName: 'John',
            lastName: 'Doe',
            patronymic: 'Иванович',
            birthDate: '1990-01-01',
            phone: '+79123456789',
            email: 'john@example.com',
            amount: 10000,
            term: 12,
            passport: null,
            registrationAddress: null,
            residenceAddress: null,
            policyAgreement: true,
            channelId: 0
        );

        $this->assertFalse($this->checker->isComplete($dto));
    }
}
