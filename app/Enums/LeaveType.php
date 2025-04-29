<?php

namespace App\Enums;

use App\Traits\Listable;

enum LeaveType: string
{
    use Listable;

    case VACATION_LEAVE = 'Vacation Leave';
    case OFFICIAL_BUSINESS = 'Official Business';
    case PERSONAL_BUSINESS = 'Personal Business';
    case APPLICATION_FOR_LEAVE = 'Application for Leave';
}