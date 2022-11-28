<?php

namespace App\Utils;

class StringUtil
{
    public static function firstCharacterOfEachWord(string $string): string
    {
        $normalized = strtolower($string);
        $initials = '';
        foreach (explode(' ', $normalized) as $word) {
            if (! empty($word)) {
                $initials .= $word[0];
            }
        }

        return strtoupper($initials);
    }
}
