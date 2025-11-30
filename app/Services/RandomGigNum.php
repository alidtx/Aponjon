<?php

namespace App\Services;

use Illuminate\Support\Str;

class RandomGigNum
{
    public static function generate(int $length = 10, bool $uppercase = true)
    {
        $random = Str::random($length);
        return $uppercase ? strtoupper($random) : $random;
    }

    public static function generateWithPrefix(string $prefix = '', int $length = 10)
    {
        $random = strtoupper(Str::random($length));
        return $prefix ? $prefix . '_' . $random : $random;
    }
}