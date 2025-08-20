<?php

namespace App\Services;

use App\DTO\ApplicationDTO;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ApplicationService
{
    /**
     * @param ApplicationDTO $applicationDTO
     * @return array
     */
    public function send(ApplicationDTO $applicationDTO): array
    {
        try {
            $response = Http::post('http://application-gateway/api/v1/applications', $applicationDTO->toArray());

            if ($response->failed()) {
                if ($response->status() === 422) {
                    return $response->json();
                }

                // Можно бросить исключение или вернуть ошибку
                throw new \RuntimeException('Ошибка при отправке заявки: ' . $response->body());
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
