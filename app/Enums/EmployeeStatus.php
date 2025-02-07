<?php

namespace App\Enums;

enum EmployeeStatus: string
{
    case SINGLE = 'Single';
    case MARRIED = 'Married';
    case WIDOW = 'Widow/Widower';
}