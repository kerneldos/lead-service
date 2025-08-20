<?php

namespace App\Services\Contracts;

use App\Exceptions\MicroserviceException;

interface MicroserviceClientInterface
{
    /**
     * Отправляет GET запрос к микросервису
     *
     * @param string $endpoint
     * @param array $queryParams
     * @return array
     * @throws MicroserviceException
     */
    public function get(string $endpoint, array $queryParams = []): array;

    /**
     * Отправляет POST запрос к микросервису
     *
     * @param string $endpoint
     * @param array $data
     * @return array
     * @throws MicroserviceException
     */
    public function post(string $endpoint, array $data): array;

    /**
     * Отправляет PUT запрос к микросервису
     *
     * @param string $endpoint
     * @param array $data
     * @return array
     * @throws MicroserviceException
     */
    public function put(string $endpoint, array $data): array;

    /**
     * Отправляет PATCH запрос к микросервису
     *
     * @param string $endpoint
     * @param array $data
     * @return array
     * @throws MicroserviceException
     */
    public function patch(string $endpoint, array $data): array;

    /**
     * Отправляет DELETE запрос к микросервису
     *
     * @param string $endpoint
     * @return array
     * @throws MicroserviceException
     */
    public function delete(string $endpoint): array;
}
