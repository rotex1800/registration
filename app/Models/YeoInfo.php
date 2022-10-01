<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YeoInfo extends Model
{
    use HasFactory;
    use HasCompletnessCheck;
    use PersonInfo;
}
