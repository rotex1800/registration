<?php

namespace App\Models;

enum DownloadableFileType: string
{
    case APPF = 'appf';

    case Rules = 'rules';

    case Flyer = 'flyer';

    public function path(): string
    {
        return match ($this) {
            self::APPF => 'APPF 2024.pdf',
            self::Rules => 'Verhaltensregeln.pdf',
            self::Flyer => 'Flyer ET 2024.pdf'
        };
    }

    public function displayName(): string
    {
        return match ($this) {
            self::APPF => 'APPF',
            self::Rules => 'Verhaltensregeln',
            self::Flyer => 'Infoflyer'
        };
    }
}
