<?php


namespace App\Services\Clients;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class PaymentStatusClient
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

    /**
     * Check payment status by order_id
     */
    public function checkStatus(string $orderId, ?string $token = null): array
    {
        try {
            $http = $this->client();
            if ($token) {
                $http = $http->withToken($token);
            }

            $url = $this->baseUrl . "/api/v1/payments/status/{$orderId}";

            $response = $http->get($url);

            return $response->json();

        } catch (ConnectionException $e) {
            return [
                'success' => false,
                'error' => [
                    'code' => 500,
                    'message' => 'Payment status service unavailable',
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
}
