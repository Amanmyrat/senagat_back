<?php

namespace App\Services;

use App\Services\Clients\BeletClient;

class BankResolverService
{
    protected BeletClient $beletClient;

    public function __construct(BeletClient $beletClient)
    {
        $this->beletClient = $beletClient;
    }

    public function resolveIdByName(string $bankName): ?int
    {
        $banks = $this->beletClient->getBanks();

        $items = $banks['data']['items'] ?? [];

        foreach ($items as $bank) {
            if (($bank['bank_name'] ?? null) === $bankName) {
                return $bank['id'];
            }
        }

        return null;
    }
}
