<?php

namespace App\Models;

enum DocumentCategory
{
    case PassportCopy;
    case Unknown;

    public static function createFromString(string $value): DocumentCategory
    {
        if ($value == 'passport') {
            return self::PassportCopy;
        }

        return DocumentCategory::Unknown;
    }
}
