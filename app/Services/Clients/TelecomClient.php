<?php

namespace App\Services\Clients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelecomClient
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
                ->post($this->baseUrl.'/api/v1/telecom/top-up', $payload)
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
            $response = $this->client()
                ->get($this->baseUrl.'/api/v1/telecom/balances', [
                    'account' => $phone,
                ])
                ->json();

            return $response;
        } catch (ConnectionException $e) {
            Log::error('TelecomClient::getBalance ConnectionException', [
                'message' => $e->getMessage(),
            ]);

            return $this->noConnection();
        } catch (\Throwable $e) {
            Log::error('TelecomClient::getBalance Throwable', [
                'message' => $e->getMessage(),
            ]);

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
