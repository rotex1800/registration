<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselorInfo extends Model
{
    use HasFactory;
    use PersonInfo;
    use HasCompletnessCheck;
}
