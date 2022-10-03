<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{
    use HasFactory;

    /**
     * Possible Document types
     */
    public const TYPE_DIGITAL = 0;

    public const TYPE_ANALOG = 1;

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Indicates whether the document is approved.
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return DocumentState::Approved->value == $this->state;
    }

    /**
     * Indicates whether the document is submitted.
     *
     * @return bool
     */
    public function isSubmitted(): bool
    {
        return DocumentState::Submitted->value == $this->state;
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
