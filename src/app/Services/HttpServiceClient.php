<?php

namespace App\Services;

use App\Exceptions\MicroserviceException;
use App\Services\Contracts\MicroserviceClientInterface;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;

class HttpServiceClient implements MicroserviceClientInterface
{
    private string $baseUrl;
    private array $defaultHeaders;
    private float $timeout;

    public function __construct(
        string $baseUrl,
        array $defaultHeaders = [],
        float $timeout = 5.0
    ) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->defaultHeaders = $defaultHeaders;
        $this->timeout = $timeout;
    }

    public function get(string $endpoint, array $queryParams = []): array
    {
        return $this->request('GET', $endpoint, [
            'query' => $queryParams
        ]);
    }

    public function post(string $endpoint, array $data): array
    {
        return $this->request('POST', $endpoint, [
            'json' => $data
        ]);
    }

    public function put(string $endpoint, array $data): array
    {
        return $this->request('PUT', $endpoint, [
            'json' => $data
        ]);
    }

    public function patch(string $endpoint, array $data): array
    {
        return $this->request('PATCH', $endpoint, [
            'json' => $data
        ]);
    }

    public function delete(string $endpoint): array
    {
        return $this->request('DELETE', $endpoint);
    }


    private function request(string $method, string $endpoint, array $options = []): array
    {
        try {
            $response = Http::withHeaders($this->defaultHeaders)
                ->timeout($this->timeout)
                ->send($method, $this->baseUrl . $endpoint, $options)
                ->throw();

            return $this->processResponse($response);
        } catch (RequestException|ConnectionException|Exception $e) {
            echo '<pre>' . print_r([$e->getMessage(), $options], true) . '</pre>'; die('s');
//            throw new MicroserviceException(
//                $this->getErrorMessage($e),
//                $e->response?->status() ?? 500,
//                $e
//            );
        }
    }

    private function processResponse(Response $response): array
    {
        $data = $response->json();

        if ($data === null) {
            throw new MicroserviceException("Invalid JSON response from microservice");
        }

        return $data;
    }

    private function getErrorMessage(RequestException $e): string
    {
        if ($e->response) {
            $responseData = $e->response->json();
            return $responseData['message'] ?? $e->response->reason();
        }

        return "Microservice request failed: " . $e->getMessage();
    }
}
