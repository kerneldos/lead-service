<?php

namespace App\Services\Contracts;

use App\DTO\LeadDTO;

/**
 * Интерфейс для определения полноты лида
 */
interface LeadCompletenessCheckerInterface
{
    /**
     * @param LeadDTO $lead
     * @return bool
     */
    public function isComplete(LeadDTO $lead): bool;
}
