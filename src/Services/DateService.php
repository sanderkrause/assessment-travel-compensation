<?php

declare(strict_types=1);

namespace App\Services;

class DateService
{
    public function findFirstMondayOfMonth(string $month, int|string $year): string
    {
        $date = new \DateTime(sprintf('first monday of %s %d', $month, $year));
        return $date->format('Y-m-d');
    }

    public function getAllMonths(): array
    {
        return [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];
    }

    public function getNextMonth(string $month): \DateTime
    {
        $date = new \DateTime(sprintf('first day of %s', $month));
        $date->modify('+1 month');
        return $date;
    }
}
