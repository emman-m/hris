<?php

namespace App\Libraries\Policy;

use App\Enums\UserRole;

class AuthPolicy
{
    public function isAdmin()
    {
        return session()->get('role') === UserRole::ADMIN->value;
    }

    public function isHrAdmin()
    {
        return session()->get('role') === UserRole::HR_ADMIN->value;
    }

    public function isHrStaff()
    {
        return session()->get('role') === UserRole::HR_STAFF->value;
    }

    public function isEmployee()
    {
        return session()->get('role') === UserRole::EMPLOYEE->value;
    }
}
