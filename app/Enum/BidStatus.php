<?php

namespace App\Enum;
use App\Enum\Attributes\EnumAttributes;
enum BidStatus: string
{
    use EnumAttributes;

    case Pending = 'pending';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
}
