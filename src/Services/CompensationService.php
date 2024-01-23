<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;

class CompensationService
{
    private const array COMPENSATION_RATES = [
        'car' => 0.10,
        'bus' => 0.25,
        'train' => 0.25,
        'bike' => 0.50
    ];

    private const BIKE_EXTRA_COMPENSATION_DISTANCE = 5;

    private const BIKE_EXTRA_COMPENSATION_RATE = 1.0;

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
    public function getDailyCompensation(int $distance, string $transport): float
    {
        $rate = self::COMPENSATION_RATES[$transport] ?? 0.0;
        switch (TransportType::tryFrom($transport)) {
            case TransportType::CAR:
            case TransportType::BUS:
            case TransportType::TRAIN:
                return $distance * $rate * 2;
            case TransportType::BIKE:
                if ($distance > self::BIKE_EXTRA_COMPENSATION_DISTANCE) {
                    $extraCompensation = min(self::BIKE_EXTRA_COMPENSATION_DISTANCE, $distance - self::BIKE_EXTRA_COMPENSATION_DISTANCE) * self::BIKE_EXTRA_COMPENSATION_RATE;
                    $regularCompensation = ($distance - self::BIKE_EXTRA_COMPENSATION_DISTANCE) * $rate;
                    return ($extraCompensation + $regularCompensation) * 2;
                }
                return $distance * $rate * 2;
        }
        return $rate;
    }

    public function calculateMonthlyCompensation(float $baseCompensation, int $workdaysPerWeek): float
    {
        return round(($this->calculateWeeklyCompensation($baseCompensation, $workdaysPerWeek) * 52) / 12, 2);
    }

    public function calculateWeeklyCompensation(float $dailyCompensation, int $workdaysPerWeek): float
    {
        return $dailyCompensation * ceil($workdaysPerWeek);
    }

    public function calculateWeeklyDistanceTraveled(int $distance, float $workdaysPerWeek): float
    {
        return $distance * ceil($workdaysPerWeek) * 2;
    }

    public function calculateMonthlyDistanceTraveled(int $distance, float $workdaysPerWeek): float|int
    {
        $weeklyDistance = $this->calculateWeeklyDistanceTraveled($distance, $workdaysPerWeek);
        return round(($weeklyDistance * 52) / 12, 2);
    }

    public function getPaymentDate(string $month): string
    {
        $nextMonth = $this->dateService->getNextMonth($month);

        return $this->dateService->findFirstMondayOfMonth($nextMonth->format('F'), $nextMonth->format('Y'));
    }
}
