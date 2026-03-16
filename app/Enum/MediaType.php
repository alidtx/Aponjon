<?php

namespace App\Enums;

use App\Enums\Attributes\Description;
use App\Enums\Attributes\EnumAttributes;

enum MediaType: string
{
    use EnumAttributes;

    case IMAGE = 'image';
    #[Description('PDF')]
    case PDF = 'pdf';
    case DOCUMENT = 'document';
    case OTHERS = 'others';
}
