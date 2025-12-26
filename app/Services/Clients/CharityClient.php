<?php

namespace App\Services\Clients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class CharityClient
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.payment_api.url');

    }

    protected function client()
    {
        return Http::withHeaders([
            'Accept' => 'application/json',
        ]);
    }

    public function create(array $payload): array
    {
        try {
            return $this->client()
                ->post($this->baseUrl.'/api/v1/charity', $payload)
                ->json();

        } catch (ConnectionException $e) {
            return [
                'success' => false,
                'error' => [
                    'code' => 503,
                    'message' => 'Charity service unreachable',
                ],
                'data' => null,
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error' => [
                    'code' => 500,
                    'message' => $e->getMessage(),
                ],
                'data' => null,
            ];
        }
    }
    public function checkStatus(array $payload): array
    {
        try {
            return $this->client()
                ->post($this->baseUrl.'/api/v1/check-status', $payload)
                ->json();
        } catch (ConnectionException $e) {
            return $this->noConnection();
        }
    }
    protected function noConnection(): array
    {
        return [
            'success' => false,
            'error' => [
                'code' => 500,
                'message' => 'Charity service unavailable',
            ],
            'data' => null,
        ];
    }
}
