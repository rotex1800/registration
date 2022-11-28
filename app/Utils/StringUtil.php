<?php

namespace App\Utils;

class StringUtil
{
    /**
     * Returns the first letter of each word in the string. Ignores all non-alpha characters.
     *
     * @param  string  $string
     * @return string
     */
    public static function firstCharacterOfEachWord(string $string): string
    {
        $normalized = preg_replace('/[^a-z ]/', '', strtolower($string));
        $initials = '';
        foreach (explode(' ', $normalized) as $word) {
            if (! empty($word)) {
                $initials .= $word[0];
            }
        }

        return strtoupper($initials);
    }
}
