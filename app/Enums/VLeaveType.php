<?php

namespace App\Enums;

use App\Traits\Listable;

enum VLeaveType: string
{
    use Listable;

    case SICK_LEAVE = 'Sick Leave';
    case VACATION_LEAVE = 'Vacation Leave';
    case STUDY_LEAVE = 'Study Leave';
    case EMERGENCY_LEAVE = 'Emergency Leave';
    case MATERNITY_LEAVE = 'Maternity Leave';
    case PATERNITY_LEAVE = 'Paternity Leave';
    case BEREAVEMENT_LEAVE = 'Bereavement Leave';
    case SERVICE_INCENTIVE_LEAVE = 'Service Incentive Leave';
    case OTHERS = 'Others';
}