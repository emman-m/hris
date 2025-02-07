<?php

namespace App\Enums;

use App\Traits\Listable;

enum EmployeeDepartment: string
{
    use Listable;

    case LOWER_SCHOOL = 'Lower School';
    case MIDDLE_HIGH_SCHOOL = 'Middle High School';
    case JUNIOR_HIGH_SCHOOL = 'Junior High School';
    case SENIOR_HIGH_SCHOOL = 'Senior High School';
    case COLLEGE = 'College';
    case NON_TEACHING_PERSONNEL = 'Non Teaching Personnel';
}
