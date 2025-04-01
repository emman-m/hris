<?php

namespace App\Enums;

use App\Traits\Listable;

enum ApproveStatus: string
{
    use Listable;

    case PENDING = 'Pending';
    case APPROVED = 'Approved';
    case CANCELLED = 'Cancelled';
    case DENIED = 'Denied';
}