<?php

namespace App\Services;

use App\Enum\ErrorMessage;
use App\Models\CreditApplication;
use App\Models\CreditType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreditApplicationService
{
    /**
     * Create a new credit application (single-step)
     */
    public function createLoanOrder(array $data, $user): CreditApplication
    {
        if (! $user->profile) {
            throw new \Exception(ErrorMessage::USER_PROFILE_REQUIRED->value);
        }

        return DB::transaction(function () use ($data, $user) {

            $credit = CreditType::findOrFail($data['credit_id']);

            $data['interest'] = $credit->interest;
            $data['status'] = 'pending';
            $data['monthly_payment'] = $this->calculateMonthlyPayment(
                $data['amount'],
                $credit->interest,
                $data['term']
            );
            if (isset($data['salary_document'])) {
                $data['salary_document'] = $this->storeFile($data['salary_document']);
            }
            if (isset($data['profit_document'])) {
                $data['profit_document'] = $this->storeFile($data['profit_document']);
            }

            return CreditApplication::create(array_merge($data, [
                'user_id' => $user->id,
                'profile_id' => $user->profile->id,
            ]));

        });
    }

    private function storeFile($file): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        return $file->storeAs(
            'credit_applications',
            $filename,
            'public'
        );
    }

    /**
     * Get pending application for user
     */
    public function getPending($user): CreditApplication
    {
        return $user->applications()
            ->where('status', 'pending')
            ->latest()
            ->firstOrFail();
    }
    /**
     * Calculate Monthly Payment Method
     */
    private function calculateMonthlyPayment(float $amount, float $annualInterest, int $term): float
    {
        $termInMonths = $term * 12;
        $yearlyInterest = $amount * $annualInterest / 100;
        $monthlyInterest = $yearlyInterest / 12;
        $monthlyPrincipal = $amount / $termInMonths;
        return round($monthlyInterest + $monthlyPrincipal, 2);
    }
}
