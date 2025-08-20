<?php

namespace App\Factories;

use App\DTO\LeadDTO;
use App\Entities\Lead;

/**
 * Фабрика для создания лидов
 */
class LeadFactory
{
    /**
     * @param LeadDTO $dto
     * @param bool $isFull
     * @return Lead
     */
    public function createFromDTO(LeadDTO $dto, bool $isFull): Lead
    {
        return new Lead(
            id: null,
            channelId: $dto->channelId,
            data: [
                'first_name' => $dto->firstName,
                'last_name' => $dto->lastName,
                'patronymic' => $dto->patronymic,
                'birth_date' => $dto->birthDate,
                'phone' => $dto->phone,
                'email' => $dto->email,
                'amount' => $dto->amount,
                'term' => $dto->term,
                'passport' => $dto->passport ? [
                    'series' => $dto->passport->series,
                    'number' => $dto->passport->number,
                    'issued_by' => $dto->passport->issuedBy,
                    'issued_date' => $dto->passport->issuedDate,
                    'division_code' => $dto->passport->divisionCode
                ] : null,
                'registration_address' => $dto->registrationAddress ? [
                    'region' => $dto->registrationAddress->region,
                    'city' => $dto->registrationAddress->city,
                    'street' => $dto->registrationAddress->street,
                    'house' => $dto->registrationAddress->house,
                    'housing' => $dto->registrationAddress->housing,
                    'flat' => $dto->registrationAddress->flat
                ] : null,
                'residence_address' => $dto->residenceAddress ? [
                    'region' => $dto->residenceAddress->region,
                    'city' => $dto->residenceAddress->city,
                    'street' => $dto->residenceAddress->street,
                    'house' => $dto->residenceAddress->house,
                    'housing' => $dto->residenceAddress->housing,
                    'flat' => $dto->residenceAddress->flat
                ] : null,
                'policy_agreement' => $dto->policyAgreement
            ],
            isFull: $isFull,
            processedAt: null,
            createdAt: new \DateTime()
        );
    }
}
