<?php

declare(strict_types=1);

namespace App\Services;

enum TransportType: string
{
    case CAR = 'car';
    case PUBLIC = 'public';
    case BIKE = 'bike';
}
