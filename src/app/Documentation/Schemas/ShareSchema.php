<?php

namespace App\Documentation\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ValidationError",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="errors", type="object",
 *         @OA\Property(property="field_name", type="array",
 *             @OA\Items(type="string", example="Поле field_name обязательно для заполнения.")
 *         )
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="UnauthorizedError",
 *     @OA\Property(property="error", type="string", example="Неавторизован"),
 *     @OA\Property(property="message", type="string", example="Токен аутентификации отсутствует или недействителен")
 * )
 *
 * @OA\Schema(
 *     schema="NotFoundError",
 *     @OA\Property(property="error", type="string", example="Не найдено"),
 *     @OA\Property(property="message", type="string", example="Запрашиваемый ресурс не найден")
 * )
 *
 * @OA\Schema(
 *     schema="ServerError",
 *     @OA\Property(property="error", type="string", example="Ошибка сервера"),
 *     @OA\Property(property="message", type="string", example="На сервере произошла ошибка")
 * )
 */
class ShareSchema {}
