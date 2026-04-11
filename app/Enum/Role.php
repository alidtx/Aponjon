<?php

namespace App\Enum;
use App\Enum\Attributes\EnumAttributes;
enum Role: string
{
    use EnumAttributes;

    case Admin = 'admin';
    case Customer = 'customer';
    case Tasker = 'tasker';
}
