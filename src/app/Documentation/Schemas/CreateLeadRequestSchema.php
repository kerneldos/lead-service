<?php

namespace App\Documentation\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CreateLeadRequest",
 *     required={"first_name", "last_name", "phone", "email", "amount", "term", "policy_agreement"},
 *     @OA\Property(property="first_name", type="string", maxLength=255, example="Иван"),
 *     @OA\Property(property="last_name", type="string", maxLength=255, example="Иванов"),
 *     @OA\Property(property="patronymic", type="string", maxLength=255, nullable=true, example="Иванович"),
 *     @OA\Property(property="birth_date", type="string", format="date", nullable=true, example="1990-01-01"),
 *     @OA\Property(property="phone", type="string", maxLength=20, example="+79161234567"),
 *     @OA\Property(property="email", type="string", format="email", maxLength=255, example="ivan@example.com"),
 *     @OA\Property(property="amount", type="number", format="float", example=50000),
 *     @OA\Property(property="term", type="integer", example=14),
 *     @OA\Property(property="policy_agreement", type="boolean", example=true),
 *     @OA\Property(property="channel_id", type="integer", nullable=true, example=1),
 *     @OA\Property(
 *         property="passport",
 *         type="object",
 *         nullable=true,
 *         @OA\Property(property="series", type="string", minLength=4, maxLength=4, example="1234"),
 *         @OA\Property(property="number", type="string", minLength=6, maxLength=6, example="567890"),
 *         @OA\Property(property="issued_by", type="string", example="УФМС города Москвы"),
 *         @OA\Property(property="issued_date", type="string", format="date", example="2015-04-25"),
 *         @OA\Property(property="division_code", type="string", example="770-123")
 *     ),
 *     @OA\Property(
 *         property="address_registration",
 *         type="object",
 *         nullable=true,
 *         @OA\Property(property="region", type="string", example="Московская область"),
 *         @OA\Property(property="city", type="string", example="Москва"),
 *         @OA\Property(property="street", type="string", example="Ленина"),
 *         @OA\Property(property="house", type="string", example="10"),
 *         @OA\Property(property="housing", type="string", nullable=true, example="А"),
 *         @OA\Property(property="flat", type="string", nullable=true, example="25")
 *     ),
 *     @OA\Property(
 *          property="address_residence",
 *          type="object",
 *          nullable=true,
 *          @OA\Property(property="region", type="string", example="Московская область"),
 *          @OA\Property(property="city", type="string", example="Москва"),
 *          @OA\Property(property="street", type="string", example="Ленина"),
 *          @OA\Property(property="house", type="string", example="10"),
 *          @OA\Property(property="housing", type="string", nullable=true, example="А"),
 *          @OA\Property(property="flat", type="string", nullable=true, example="25")
 *      )
 * )
 */
class CreateLeadRequestSchema {}
