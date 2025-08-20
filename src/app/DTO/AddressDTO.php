<?php

namespace App\DTO;

readonly class AddressDTO
{
    public function __construct(
        public string  $type, // registration|residence
        public string  $region,
        public string  $city,
        public string  $street,
        public string  $house,
        public ?string $housing,
        public ?string $flat
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            region: $data['region'],
            city: $data['city'],
            street: $data['street'],
            house: $data['house'],
            housing: $data['housing'] ?? null,
            flat: $data['flat'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'region' => $this->region,
            'city' => $this->city,
            'street' => $this->street,
            'house' => $this->house,
            'housing' => $this->housing,
            'flat' => $this->flat,
        ];
    }
}
