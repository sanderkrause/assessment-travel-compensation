<?php

declare(strict_types=1);

namespace App\Services;

class EmployeeService
{
    /**
     * Returns employee data as if it was retrieved from a database.
     * @return array[]
     */
    public function getEmployees(): array
    {
        return [
            [
                'employee' => 'Paul',
                'transport' => 'car',
                'distance' => 60,
                'workdays' => 5,
            ],
            [
                'employee' => 'Martin',
                'transport' => 'bus',
                'distance' => 8,
                'workdays' => 4
            ],
            [
                'employee' => 'Jeroen',
                'transport' => 'bike',
                'distance' => 9,
                'workdays' => 5
            ],
            [
                'employee' => 'Tineke',
                'transport' => 'bike',
                'distance' => 4,
                'workdays' => 3
            ],
            [
                'employee' => 'Arnout',
                'transport' => 'train',
                'distance' => 23,
                'workdays' => 5
            ],
            [
                'employee' => 'Matthijs',
                'transport' => 'bike',
                'distance' => 11,
                'workdays' => 4.5
            ],
            [
                'employee' => 'Rens',
                'transport' => 'car',
                'distance' => 12,
                'workdays' => 5
            ],
        ];
    }
}
