<?php

namespace App\Http\Controllers;

use App\DTO\AddressDTO;
use App\DTO\LeadDTO;
use App\DTO\PassportDTO;
use App\Http\Requests\CreateLeadRequest;
use App\Services\Contracts\LeadProcessorInterface;

readonly class LeadController
{
    /**
     * @param LeadProcessorInterface $leadProcessor
     */
    public function __construct(
        private LeadProcessorInterface $leadProcessor
    ) {}

    /**
     * @param CreateLeadRequest $request
     * @return array
     */
    public function create(CreateLeadRequest $request): array
    {
        $validated = $request->validated();

        $leadDTO = $this->createLeadDTOFromRequest($validated);
        $result = $this->leadProcessor->process($leadDTO);

        return [
            'success' => true,
            'lead_id' => $result['lead_id'],
            'client_response' => $result['client_response'],
            'application_response' => $result['application_response']
        ];
    }

    /**
     * @param array $request
     * @return LeadDTO
     */
    private function createLeadDTOFromRequest(array $request): LeadDTO
    {
        $passport = null;
        if (isset($request['passport'])) {
            $passport = new PassportDTO(
                series: $request['passport']['series'],
                number: $request['passport']['number'],
                issuedBy: $request['passport']['issued_by'],
                issuedDate: $request['passport']['issued_date'],
                divisionCode: $request['passport']['division_code']
            );
        }

        $registrationAddress = null;
        if (isset($request['address_registration'])) {
            $registrationAddress = new AddressDTO(
                type: 'registration',
                region: $request['address_registration']['region'],
                city: $request['address_registration']['city'],
                street: $request['address_registration']['street'],
                house: $request['address_registration']['house'],
                housing: $request['address_registration']['housing'] ?? null,
                flat: $request['address_registration']['flat'] ?? null
            );
        }

        $residenceAddress = null;
        if (isset($request['address_residence'])) {
            $residenceAddress = new AddressDTO(
                type: 'residence',
                region: $request['address_residence']['region'],
                city: $request['address_residence']['city'],
                street: $request['address_residence']['street'],
                house: $request['address_residence']['house'],
                housing: $request['address_residence']['housing'] ?? null,
                flat: $request['address_residence']['flat'] ?? null
            );
        }

        return new LeadDTO(
            firstName: $request['first_name'],
            lastName: $request['last_name'],
            patronymic: $request['patronymic'] ?? null,
            birthDate: $request['birth_date'] ?? null,
            phone: $request['phone'],
            email: $request['email'],
            amount: $request['amount'],
            term: $request['term'],
            passport: $passport,
            registrationAddress: $registrationAddress,
            residenceAddress: $residenceAddress,
            policyAgreement: $request['policy_agreement'],
            channelId: $request['channel_id'] ?? 1
        );
    }
}
