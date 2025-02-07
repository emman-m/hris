<?php

namespace App\Enums;

enum EmployeeStatus: string
{
    case SINGLE = 'Single';
    // C:\wamp64\www\hris\app\Validations\EmployeeUserValidator.php
    case MARRIED = 'Married';
    case WIDOW = 'Widow/Widower';
}