<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Document
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $type
 * @property int $is_required
 * @property \App\Models\DocumentState|null $state
 * @property string $name
 * @property int $owner_id
 * @property string|null $path
 * @property \App\Models\DocumentCategory|null $category
 * @property-read Model|\Eloquent $documentable
 * @property-read \App\Models\User|null $owner
 *
 *
 * @method static \Database\Factories\DocumentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Document extends Model
{
    use HasFactory;

    /**
     * Possible Document types
     */
    public const TYPE_DIGITAL = 0;

    public const TYPE_ANALOG = 1;

    protected $casts = [
        'state' => DocumentState::class,
        'category' => DocumentCategory::class,
    ];

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
        return DocumentState::Approved == $this->state;
    }

    /**
     * Indicates whether the document is submitted.
     *
     * @return bool
     */
    public function isSubmitted(): bool
    {
        return DocumentState::Submitted == $this->state;
    }

    /**
     * @return BelongsTo<User, Document>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
