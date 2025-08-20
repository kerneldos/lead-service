<?php

namespace App\DTO;

use Carbon\Carbon;

/**
 * @property integer|null     $id
 * @property string           $firstName
 * @property string           $lastName
 * @property string|null      $patronymic
 * @property Carbon|null      $birthDate
 * @property string           $phone
 * @property string           $email
 * @property PassportDTO|null $passport
 * @property AddressDTO[]     $addresses
 */
readonly class ClientDTO
{
    public function __construct(
        public ?int         $id,
        public string       $firstName,
        public string       $lastName,
        public ?string      $patronymic,
        public ?string      $birthDate,
        public string       $phone,
        public string       $email,
        public ?PassportDTO $passport = null,
        public array        $addresses = []
    ) {}

    /**
     * Создание DTO из массива
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            patronymic: $data['patronymic'] ?? null,
            birthDate: $data['birth_date'] ?? null,
            phone: $data['phone'],
            email: $data['email'],
            passport: isset($data['passport'])
                ? PassportDTO::fromArray($data['passport'])
                : null,
            addresses: isset($data['addresses'])
                ? array_map(fn($addr) => AddressDTO::fromArray($addr), $data['addresses'])
                : [],
        );
    }

    /**
     * Преобразование DTO в массив в формате для CreateClientRequest
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'patronymic' => $this->patronymic,
            'birth_date' => $this->birthDate,
            'phone' => $this->phone,
            'email' => $this->email,
            'passport' => $this->passport?->toArray(),
            'addresses' => array_map(fn(AddressDTO $addr) => $addr->toArray(), $this->addresses),
        ];
    }
}
