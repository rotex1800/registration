<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @template T
 */
trait PersonInfo
{
    /**
     * Inverse of the one-to-one relation between a user and PersonInfo
     *
     *
     * @retrun  BelongsTo<User, T>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
