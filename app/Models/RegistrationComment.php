<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationComment extends Model
{
    use HasFactory, HasCompletenessCheck;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isComplete(): bool
    {
        return $this->body != null && trim($this->body) != '';
    }
}
