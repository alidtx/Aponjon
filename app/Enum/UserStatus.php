<?php

namespace App\Enums;
use App\Enum\Attributes\EnumAttributes;

enum UserStatus: string
{
    use EnumAttributes;

    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
