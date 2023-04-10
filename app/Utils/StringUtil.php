<?php

namespace App\Utils;

class StringUtil
{
    /**
     * Returns the first letter of each word in the string. Ignores all non-alpha characters.
     */
    public static function firstCharacterOfEachWord(string $string): string
    {
        $normalized = preg_replace('/[^a-z ]/', '', strtolower($string));
        $normalized = strval($normalized);
        $initials = '';
        foreach (explode(' ', $normalized) as $word) {
            if (! empty($word)) {
                $initials .= $word[0];
            }
        }

        return strtoupper($initials);
    }
}
