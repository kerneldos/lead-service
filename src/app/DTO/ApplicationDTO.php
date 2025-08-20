<?php

namespace App\DTO;

readonly class ApplicationDTO
{
    public function __construct(
        public ?int    $id,
        public int     $leadId,
        public int     $clientId,
        public float   $amount,
        public int     $term,
        public string  $region,
        public string  $city,
        public bool    $personalDataAgreement,
        public ?string $personalDataAgreementDate,
        public ?array  $additionalData
    ) {}

    /**
     * Создание DTO из массива
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            leadId: $data['leadId'],
            clientId: $data['clientId'],
            amount: $data['amount'] ?? null,
            term: $data['term'] ?? null,
            region: $data['region'],
            city: $data['city'],
            personalDataAgreement: $data['personal_data_agreement'] ?? null,
            personalDataAgreementDate: $data['personal_data_agreement_date'] ?? null,
            additionalData: $data['additional_data'] ?? null,
        );
    }

    /**
     * Преобразование DTO в массив
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'lead_id' => $this->leadId,
            'client_id' => $this->clientId,
            'amount' => $this->amount,
            'term' => $this->term,
            'region' => $this->region,
            'city' => $this->city,
            'personal_data_agreement' => $this->personalDataAgreement,
            'personal_data_agreement_date' => $this->personalDataAgreementDate,
            'additional_data' => $this->additionalData,
        ];
    }
}
