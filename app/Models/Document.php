<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'physical' => 1,
    ];

    public const APPROVED = 'approved';

    public const SUBMITTED = 'submitted';

    /**
     * Indicates whether the document is approved.
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return self::APPROVED == $this->state;
    }

    /**
     * Indicates whether the document is submitted.
     *
     * @return bool
     */
    public function isSubmitted(): bool
    {
        return self::SUBMITTED == $this->state;
    }

    /**
     * @return BelongsTo
     * @phpstan-return BelongsTo<User>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
