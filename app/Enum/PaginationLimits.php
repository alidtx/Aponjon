<?php

namespace App\Enum;

enum PaginationLimits: int
{

    case PER_PAGE_FIFTEEN = 15;
    case PER_PAGE_TWENTY = 20;
    case PER_PAGE_FIFTY = 50;
    case PER_PAGE_HUNDRED = 100;
    case PER_PAGE_TWO_HUNDRED = 200;
    case PER_PAGE_FIVE_HUNDRED = 500;
}
