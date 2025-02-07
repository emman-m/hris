<?php

namespace App\Enums;

use App\Traits\Listable;

enum UserRole: string
{
    use Listable;

    case ADMIN = 'Admin';
    case HR_ADMIN = 'HR Admin';
    case HR_STAFF = 'HR Staff';
    case EMPLOYEE = 'Employee';
}
