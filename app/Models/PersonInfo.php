<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait PersonInfo
{
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
