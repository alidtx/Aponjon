<?php

namespace App\Enum;

use App\Enum\Attributes\EnumAttributes;

enum TaskStatus: string
{
    use EnumAttributes;

    case Posted      = 'posted';
    case Assigned    = 'assigned';
    case InProgress  = 'in_progress';
    case Completed   = 'completed';
    case Cancelled   = 'cancelled';
    case Disputed    = 'disputed';
}