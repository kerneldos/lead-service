<?php

namespace Tests\Unit\Services;

use App\DTO\ClientDTO;
use App\DTO\LeadDTO;
use App\Entities\Lead;
use App\Factories\LeadFactory;
use App\Repositories\Contracts\LeadRepositoryInterface;
use App\Services\ApplicationService;
use App\Services\Contracts\LeadCompletenessCheckerInterface;
use App\Services\LeadProcessorService;
use Tests\TestCase;

class LeadProcessorServiceTest extends TestCase
{
    private LeadProcessorService $service;
    private $leadRepository;
    private $completenessChecker;
    private $leadFactory;
    private $clientService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->leadRepository = $this->createMock(LeadRepositoryInterface::class);
        $this->completenessChecker = $this->createMock(LeadCompletenessCheckerInterface::class);
        $this->leadFactory = $this->createMock(LeadFactory::class);
        $this->clientService = $this->createMock(ApplicationService::class);

        $this->service = new LeadProcessorService(
            $this->leadRepository,
            $this->completenessChecker,
            $this->leadFactory,
            $this->clientService
        );
    }

    public function testProcessesLeadSuccessfully()
    {
        $dto = new LeadDTO(
            firstName: 'Иван',
            lastName: 'Петров',
            patronymic: null,
            birthDate: null,
            phone: '+79123456789',
            email: 'real@domain.com',
            amount: 10000,
            term: 12,
            passport: null,
            registrationAddress: null,
            residenceAddress: null,
            policyAgreement: true,
            channelId: 1
        );

        $lead = new Lead(null, 1, [], false, null, new \DateTime());
        $savedLead = new Lead(1, 1, [], false, null, new \DateTime());

        $this->completenessChecker->method('isComplete')
            ->willReturn(false);

        $this->leadFactory->method('createFromDTO')
            ->willReturn($lead);

        $this->leadRepository->expects($this->exactly(2))
            ->method('save')
            ->willReturn($savedLead);

        $this->clientService->expects($this->once())
            ->method('sendClient')
            ->willReturn(['id' => 101]);

        $result = $this->service->process($dto);

        $this->assertEquals(1, $result['lead_id']);
        $this->assertEquals(['id' => 101], $result['client_response']);
    }
}
