<?php

namespace App\Documentation;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API Сервиса Лидов",
 *     version="1.0.0",
 *     description="API для обработки лидов и создания заявок"
 * )
 * @OA\Tag(
 *     name="Leads",
 *     description="Операции с лидами"
 * )
 */
class LeadAnnotations {
    /**
     * Создание нового лида
     *
     * @OA\Post(
     *     path="/api/leads",
     *     tags={"Leads"},
     *     summary="Создать новый лид",
     *     description="Обработать новый лид и создать клиента/заявку",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateLeadRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Лид успешно создан",
     *         @OA\JsonContent(ref="#/components/schemas/LeadResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизован",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthorizedError")
     *     )
     * )
     */
    public function store(): void {}
}
