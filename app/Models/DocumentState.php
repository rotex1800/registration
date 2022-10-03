<?php

namespace App\Models;

enum DocumentState: string
{
    case Submitted = 'submitted';
    case Approved = 'approved';
}
