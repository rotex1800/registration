<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

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

    /**
     * @return BelongsTo
     * @phpstan-return BelongsTo<User>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
