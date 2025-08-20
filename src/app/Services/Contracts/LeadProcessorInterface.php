<?php

namespace App\Services\Contracts;

use App\DTO\LeadDTO;

/**
 * Интерфейс для обработки лидов
 */
interface LeadProcessorInterface
{
    /**
     * @param LeadDTO $leadDTO
     * @return array
     */
    public function process(LeadDTO $leadDTO): array;
}
