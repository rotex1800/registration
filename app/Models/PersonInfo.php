<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonInfo extends Model
{
    use HasFactory;

    /**
     * Inverse of the one-to-one relation between a user and PersonInfo
     *
     * @retrun BelongsTo
     * @phpstan-return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
