<?php

namespace App\Services;

use App\DTO\LeadDTO;
use App\Services\Contracts\LeadCompletenessCheckerInterface;

/**
 * Реализация проверки полноты лида
 */
class LeadCompletenessChecker implements LeadCompletenessCheckerInterface
{
    /**
     * @param LeadDTO $lead
     * @return bool
     */
    public function isComplete(LeadDTO $lead): bool
    {
        return !is_null($lead->firstName)
            && !is_null($lead->lastName)
            && !is_null($lead->birthDate)
            && !is_null($lead->phone)
            && !is_null($lead->email)
            && !is_null($lead->registrationAddress)
            && !is_null($lead->passport);
    }
}
