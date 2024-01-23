<?php

declare(strict_types=1);

namespace App\Services;

class DateService
{
    public function findFirstMondayOfMonth(string $month): string
    {
        $date = new \DateTimeImmutable(sprintf('first monday of %s', $month));
        return $date->format('Y-m-d');
    }

    public function getAllMonths(): array
    {
        return [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
    }
}
