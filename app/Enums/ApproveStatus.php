<?php

namespace App\Enums;

enum ApproveStatus: string
{
    case PENDING = 'Pending';
    case APPROVED = 'Approved';
    case DENIED = 'Denied';
}