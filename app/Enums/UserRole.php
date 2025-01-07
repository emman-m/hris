<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'Admin';
    case HR_ADMIN = 'HR Admin';
    case HR_STAFF = 'HR Staff';
    case EMPLOYEE = 'Employee';
}
