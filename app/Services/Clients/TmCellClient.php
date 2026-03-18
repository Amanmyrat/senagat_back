<?php

namespace App\Services\Clients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class TmCellClient
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
                ->post($this->baseUrl.'/api/v1/tmcell/pay', $payload)
                ->json();

        } catch (ConnectionException $e) {
            return $this->noConnection();
        } catch (\Throwable $e) {
            return $this->error(500, $e->getMessage());
        }
    }

    public function getBalance(string $phone): array
    {
        try {
            return $this->client()
                ->get($this->baseUrl.'/api/v1/tmcell/balance', [
                    'account' => $phone,
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
                'message' => 'Telecom service unavailable',
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
