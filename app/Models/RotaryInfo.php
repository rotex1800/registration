<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RotaryInfo extends Model
{
    use HasFactory, HasCompletenessCheck;

    /**
     * Inverse of the one-to-one relation between a user and RotaryInfo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isComplete(): bool
    {
        return $this->isCompleteCheck(RotaryInfo::factory()->definition());
    }
}
