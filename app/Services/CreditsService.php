<?php

namespace App\Services;

use Carbon\Carbon;

class CreditsService
{
    /**
     * @param float|int $amount
     * @return int
     */
    public function convertToInt(float|int $amount): int
    {
        return intval($amount * 100);
    }

    /**
     * @param int $amount
     * @return float
     */
    public function convertToFloat(int $amount): float
    {
        return round(floatval($amount / 100), 2);
    }

    /**
     * @param int $creditAmount
     * @param int $months
     * @return array
     */
    public function generateInstallmentSchedule(int $creditAmount, int $months): array
    {
        $currentDate = Carbon::now()->addMonth()->startOfMonth(); // Start from the next month
        $installmentSchedule = [];

        $installmentAmount = intdiv($creditAmount, $months); // Calculate base installment amount
        $reminder = $creditAmount % $months; // Calculate remainder amount

        for ($i = 0; $i < $months; $i++) {
            $paymentDate = $currentDate->copy()->addMonths($i);

            if ($i === 0 & $reminder > 0) {
                // First installment with remainder
                $installmentSchedule[] = [
                    'payment_date' => $paymentDate->format('Y-m-d'),
                    'amount' => $installmentAmount + $reminder,
                ];
            } else {
                // Regular installment
                $installmentSchedule[] = [
                    'payment_date' => $paymentDate->format('Y-m-d'),
                    'amount' => $installmentAmount,
                ];
            }
        }

        return $installmentSchedule;
    }

    public function checkLimits(int $amount): bool
    {
        if ($amount > config('credits.max_amount')) {
            return false;
        }

        return true;
    }

    public function checkRemaining($activeCreditsAmount): float
    {
        return $this->convertToFloat((config('credits.max_amount') - $activeCreditsAmount));
    }
}
