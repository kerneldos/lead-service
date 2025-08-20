<?php

namespace App\Services;

use App\DTO\ClientDTO;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ClientService
{
    /**
     * @param ClientDTO $clientDTO
     * @return array
     */
    public function sendClient(ClientDTO $clientDTO): array
    {
        try {
            $response = Http::post('http://client-gateway/api/v1/clients', $clientDTO->toArray());

            if ($response->failed()) {
                if ($response->status() === 422) {
                    return $response->json();
                }

                // Можно бросить исключение или вернуть ошибку
                throw new \RuntimeException('Ошибка при отправке клиента: ' . $response->body());
            }

            return $response->json();
        } catch (ConnectionException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
