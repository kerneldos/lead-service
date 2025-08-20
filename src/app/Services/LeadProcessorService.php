<?php

namespace App\Services;

use App\DTO\ApplicationDTO;
use App\DTO\ClientDTO;
use App\DTO\LeadDTO;
use App\Factories\LeadFactory;
use App\Repositories\Contracts\LeadRepositoryInterface;
use App\Services\Contracts\LeadCompletenessCheckerInterface;
use App\Services\Contracts\LeadProcessorInterface;
use Exception;

/**
 * Основной сервис лидов
 */
readonly class LeadProcessorService implements LeadProcessorInterface
{
    public function __construct(
        private LeadRepositoryInterface          $leadRepository,
        private LeadCompletenessCheckerInterface $completenessChecker,
        private LeadFactory                      $leadFactory,
        private ClientService                    $clientService,
        private ApplicationService               $applicationService
    ) {}

    /**
     * @param LeadDTO $leadDTO
     * @return array
     * @throws Exception
     */
    public function process(LeadDTO $leadDTO): array
    {
        // Определяем полноту лида
        $isFull = $this->completenessChecker->isComplete($leadDTO);

        // Создаем и сохраняем лид
        $lead = $this->leadFactory->createFromDTO($leadDTO, $isFull);
        $savedLead = $this->leadRepository->save($lead);

        // Создаем или обновляем клиента
        $clientDTO = $this->createClientDTO($leadDTO);
        $clientResponse = $this->clientService->sendClient($clientDTO);

        if ($clientResponse['success']) {
            // Создаем заявку
            $applicationDTO = $this->createApplicationDTO($leadDTO, $savedLead->getId(), $clientResponse['data']['id']);
            $applicationResponse = $this->applicationService->send($applicationDTO);
        } else {
            throw new Exception('Ошибка при создании/обновлении клиента');
        }

        if ($applicationResponse['success']) {
            // Отмечаем лид как обработанный
            $savedLead->markAsProcessed();
            $this->leadRepository->save($savedLead);

            return [
                'lead_id' => $savedLead->getId(),
                'client_response' => $clientResponse,
                'application_response' => $applicationResponse
            ];
        }

        throw new Exception('Ошибка при обработке лида');
    }

    private function createClientDTO(LeadDTO $lead): ClientDTO
    {
        $addresses = [];

        if ($lead->registrationAddress) {
            $addresses[] = $lead->registrationAddress;
        }

        if ($lead->residenceAddress) {
            $addresses[] = $lead->residenceAddress;
        }

        return new ClientDTO(
            id: null,
            firstName: $lead->firstName,
            lastName: $lead->lastName,
            patronymic: $lead->patronymic,
            birthDate: $lead->birthDate,
            phone: $lead->phone,
            email: $lead->email,
            passport: $lead->passport,
            addresses: $addresses
        );
    }

    private function createApplicationDTO(LeadDTO $lead, int $leadId, int $clientId): ApplicationDTO
    {
        return new ApplicationDTO(
            id: null,
            leadId: $leadId,
            clientId: $clientId,
            amount: $lead->amount,
            term: $lead->term,
            region: $lead->registrationAddress?->region ?? '',
            city: $lead->registrationAddress?->city ?? '',
            personalDataAgreement: $lead->policyAgreement,
            personalDataAgreementDate: $lead->policyAgreement ? (new \DateTime())->format('Y-m-d H:i:s') : null,
            additionalData: null
        );
    }
}
