<?php

namespace App\Documentation\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="LeadResponse",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="lead_id", type="integer", example=123),
 *     @OA\Property(property="client_id", type="integer", example=123),
 *     @OA\Property(property="application_id", type="integer", example=123)
 * )
 */
class LeadResponseSchema {}
