<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BioFamily extends Model
{
    use HasFactory, HasCompletenessCheck;

    public function isComplete(): bool
    {
        return $this->isCompleteCheck(BioFamily::factory()->definition());
    }


}
