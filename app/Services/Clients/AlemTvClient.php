<?php

namespace App\Services\Clients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class AlemTvClient
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

    public function search(string $type, string $account): array
    {
        try {
            return $this->client()
                ->get($this->baseUrl.'/api/v1/alemTv/search', [
                    'type' => $type,
                    'account' => $account,
                ])
                ->json();

        } catch (ConnectionException $e) {
            return $this->noConnection();
        } catch (\Throwable $e) {
            return $this->error(500, $e->getMessage());
        }
    }

    public function topUp(array $payload): array
    {
        try {
            return $this->client()
                ->post($this->baseUrl . '/api/v1/alemTv/topup', $payload)
                ->json();
        } catch (ConnectionException $e) {
            return $this->noConnection();
        } catch (\Throwable $e) {
            return $this->error(500, $e->getMessage());
        }
    }
    public function getTarifs(string $type): array
    {
        try {
            return $this->client()
                ->get($this->baseUrl . '/api/v1/alemTv/tarifs', [
                    'type' => $type,
                ])
                ->json();

        } catch (ConnectionException $e) {
            return $this->noConnection();
        } catch (\Throwable $e) {
            return $this->error(500, $e->getMessage());
        }
    }

    protected function noConnection(): array
    {
        return [
            'success' => false,
            'error' => [
                'code' => 500,
                'message' => 'alem_tv_service_unavailable',
            ],
            'data' => null,
        ];
    }

    protected function error(int $code, string $message): array
    {
        return [
            'success' => false,
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
            'data' => null,
        ];
    }
}
