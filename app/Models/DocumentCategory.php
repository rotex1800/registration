<?php

namespace App\Models;

enum DocumentCategory: string
{
    case PassportCopy = 'passport';
    case Unknown = 'unknown';
}
