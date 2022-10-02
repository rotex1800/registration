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

    public function rawValue(): string
    {
        if ($this == DocumentCategory::PassportCopy) {
            return 'passport';
        }
        return 'unknown';
    }
}
