<?php

namespace App\DTO;

readonly class LeadDTO
{
    public function __construct(
        public string       $firstName,
        public string       $lastName,
        public ?string      $patronymic,
        public ?string      $birthDate,
        public string       $phone,
        public string       $email,
        public float        $amount,
        public int          $term,
        public ?PassportDTO $passport,
        public ?AddressDTO  $registrationAddress,
        public ?AddressDTO  $residenceAddress,
        public bool         $policyAgreement,
        public int          $channelId
    ) {}
}
