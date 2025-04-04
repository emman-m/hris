<?php

namespace App\Enums;

use App\Traits\Listable;

enum EmployeeStatus: string
{
    use Listable;

    case SINGLE = 'Single';
    case MARRIED = 'Married';
    case WIDOW = 'Widow/Widower';
}