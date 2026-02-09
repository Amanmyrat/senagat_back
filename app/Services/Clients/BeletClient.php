<?php

namespace App\Services\Clients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BeletClient
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

    public function getBalanceRecommendations(): array
    {
        try {
            return $this->client()
                ->get($this->baseUrl.'/api/v1/belet/balances')
                ->json();
        } catch (ConnectionException $e) {
            return $this->noConnection();
        }
    }

    public function getBanks(): array
    {
        $cacheKey = 'belet:banks';
        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);

            if (
                is_array($cached) &&
                ($cached['success'] ?? true) === true
            ) {
                return $cached;
            }
            Cache::forget($cacheKey);
        }

        try {
            $ip = request()->ip();
            Log::channel('belet')->info('Belet getBanks called (API)', [
                'ip' => $ip,
            ]);
            $response = $this->client()
                ->timeout(30)
                ->get($this->baseUrl.'/api/v1/belet/banks');
            if ($response->successful()) {
                $data = $response->json();
                Cache::put($cacheKey, $data, now()->addDay());

                return $data;
            }

            return [
                'success' => false,
                'error' => [
                    'code' => $response->status(),
                    'message' => $response->body(),
                ],
                'data' => null,
            ];

        } catch (ConnectionException $e) {
            Log::channel('belet')->error('Belet getBanks connection error', [
                'message' => $e->getMessage(),
            ]);

            return $this->noConnection();
        }
    }

    public function topUp(array $payload): array
    {
        try {
            return $this->client()
                ->post($this->baseUrl.'/api/v1/belet/top-up', $payload)
                ->json();
        } catch (ConnectionException $e) {
            return $this->noConnection();
        }
    }

    public function checkPhone(string $phone)
    {
        try {
            return $this->client()
                ->post($this->baseUrl.'/api/v1/belet/check-phone', [
                    'phone' => $phone,
                ])
                ->json();
        } catch (ConnectionException $e) {
            return $this->noConnection();
        }
    }

    public function checkStatus(int|string $id): array
    {
        $url = $this->baseUrl."/api/v1/belet/orders/{$id}/status";
        try {
            $response = $this->client()->get($url);

            return $response->json();

        } catch (ConnectionException $e) {
            return $this->noConnection();
        }
    }

    public function confirm(array $query): array
    {
        try {
            return $this->client()
                ->post($this->baseUrl.'/api/v1/belet/confirm?', $query)
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
                'message' => 'Belet service unavailable',
            ],
            'data' => null,
        ];
    }
}
