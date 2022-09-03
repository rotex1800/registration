<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * Possible Document types
     *
     * @var array
     */
    public const TYPES = [
        'digital' => 0,
        'physical' => 1
    ];
}
