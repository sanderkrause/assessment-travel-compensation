<?php

namespace App\Command;

use App\Services\CompensationService;
use App\Services\DateService;
use App\Services\EmployeeService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:calculate-compensation',
    description: 'Add a short description for your command',
)]
class CalculateCompensationCommand extends Command
{
    public function __construct(
        private readonly CompensationService $compensationService,
        private readonly EmployeeService $employeeService,
        private readonly DateService $dateService,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $employees = $this->employeeService->getEmployees();

        $columns = [
            'Employee',
            'Transport',
            'Traveled Distance',
            'Compensation',
            'Payment Date',
        ];

        $rows = [];
        foreach ($this->dateService->getAllMonths() as $month) {
            $paymentDate = $this->compensationService->getPaymentDate($month);

            foreach ($employees as $employee) {
                $baseCompensation = $this->compensationService->getDailyCompensation($employee['distance'], $employee['transport']);
                // Note: using the base one-way distance because it determines the compensation rate
                $monthlyCompensation = $this->compensationService->calculateMonthlyCompensation($baseCompensation, $employee['workdays']);
                $traveledDistance = $this->compensationService->calculateMonthlyDistanceTraveled($employee['distance'], $employee['workdays']);

                $rows[] = [
                    'Employee' => $employee['employee'],
                    'Transport' => ucfirst($employee['transport']),
                    'Traveled Distance' => $traveledDistance,
                    'Compensation' => $monthlyCompensation,
                    'Payment Date' => $paymentDate,
                ];
            }
        }

        // Note: output is not handled by a service, but by the command itself as it's the only separate responsibility of this command
        $file = fopen('compensation.csv', 'w');
        fputcsv($file, $columns);
        foreach ($rows as $row) {
            fputcsv($file, $row);
        }
        fclose($file);

        $io->success('Travel cost compensation calculated and output to compensation.csv');

        return Command::SUCCESS;
    }
}
