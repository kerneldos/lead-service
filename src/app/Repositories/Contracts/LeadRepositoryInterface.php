<?php

namespace App\Repositories\Contracts;

use App\Entities\Lead;

/**
 * Репозиторий для работы с лидами
 */
interface LeadRepositoryInterface
{
    /**
     * @param Lead $lead
     * @return Lead
     */
    public function save(Lead $lead): Lead;

    /**
     * @param int $id
     * @return Lead|null
     */
    public function findById(int $id): ?Lead;
}
