<?php

namespace App\Enum;

use App\Enum\Attributes\EnumAttributes;

enum PaymentStatus: string
{
    use EnumAttributes;

    case Pending  = 'pending';
    case Paid     = 'paid';
    case Failed   = 'failed';
    case Refunded = 'refunded';
}