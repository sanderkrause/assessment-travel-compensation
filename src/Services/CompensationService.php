<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;

class CompensationService
{
    private const array COMPENSATION_RATES = [
        'car' => 0.10,
        'public' => 0.25,
        'bike' => 0.50
    ];

    public function __construct(private readonly DateService $dateService)
    {

    }

    /**
     * Compensation rate is calculated based on the distance and the transport type.
     * Rates are doubled because the distance is traveled twice a day.
     *
     * @param int $distance
     * @param string $transport
     * @return float
     */
    public function getBaseCompensation(int $distance, string $transport): float
    {
        $rate = self::COMPENSATION_RATES[$transport] ?? 0.0;
        switch (TransportType::from($transport)) {
            case TransportType::CAR:
            case TransportType::PUBLIC:
                return $distance * $rate * 2;
            case TransportType::BIKE:
                $factor = $distance >= 5 && $distance <= 10 ? 2 : 1;
                return $distance * $rate * $factor * 2;
        }
        return $rate;
    }

    public function calculateMonthlyCompensation(float $baseCompensation, int $workdaysPerWeek): float
    {
        return $this->calculateWeeklyCompensation($baseCompensation, $workdaysPerWeek) * 52 / 12;
    }

    public function calculateWeeklyCompensation(float $baseCompensation, int $workdaysPerWeek): float
    {
        return $baseCompensation * $workdaysPerWeek;
    }

    public function calculateDistanceTraveled(int $distance, float $workdaysPerWeek): float
    {
        return $distance * ceil($workdaysPerWeek) * 2;
    }

    public function getPaymentDate(string $month): string
    {
        return $this->dateService->findFirstMondayOfMonth($month);
    }
}
