<?php

namespace App\Libraries\Policy;

use App\Enums\UserRole;

class AuthPolicy
{
    public function isAdmin($role = null)
    {
        if ($role) {
            return $role === UserRole::ADMIN->value;
        }

        return session()->get('role') === UserRole::ADMIN->value;
    }

    public function isHrAdmin($role = null)
    {
        if ($role) {
            return $role === UserRole::HR_ADMIN->value;
        }

        return session()->get('role') === UserRole::HR_ADMIN->value;
    }

    public function isHrStaff($role = null)
    {
        if ($role) {
            return $role === UserRole::HR_STAFF->value;
        }

        return session()->get('role') === UserRole::HR_STAFF->value;
    }

    public function isEmployee($role = null)
    {
        if ($role) {
            return $role === UserRole::EMPLOYEE->value;
        }

        return session()->get('role') === UserRole::EMPLOYEE->value;
    }

    public function isDepartmentHead()
    {
        return session()->get('isDepartmentHead');
    }

    public function isAnyAdmin($role = null)
    {
        if ($role) {
            return in_array($role, [UserRole::ADMIN->value, UserRole::HR_ADMIN->value, UserRole::HR_STAFF->value]);
        }

        return in_array(session()->get('role'), [UserRole::ADMIN->value, UserRole::HR_ADMIN->value, UserRole::HR_STAFF->value]);
    }
}
