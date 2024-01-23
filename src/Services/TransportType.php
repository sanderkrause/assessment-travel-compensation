<?php

declare(strict_types=1);

namespace App\Services;

enum TransportType: string
{
    case CAR = 'car';
    case BUS = 'bus';
    case TRAIN = 'train';
    case BIKE = 'bike';
}
