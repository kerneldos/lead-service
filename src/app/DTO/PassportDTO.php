<?php

namespace App\DTO;

readonly class PassportDTO
{
    public function __construct(
        public string $series,
        public string $number,
        public string $issuedBy,
        public string $issuedDate,
        public string $divisionCode
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            series: $data['series'],
            number: $data['number'],
            issuedBy: $data['issued_by'],
            issuedDate: $data['issued_date'],
            divisionCode: $data['division_code']
        );
    }

    public function toArray(): array
    {
        return [
            'series' => $this->series,
            'number' => $this->number,
            'issued_by' => $this->issuedBy,
            'issued_date' => $this->issuedDate,
            'division_code' => $this->divisionCode,
        ];
    }
}
