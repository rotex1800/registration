<?php

namespace App\Models;

use Database\Factories\DocumentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Document
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $type
 * @property int $is_required
 * @property DocumentState|null $state
 * @property string $name
 * @property int $owner_id
 * @property string|null $path
 * @property DocumentCategory|null $category
 * @property-read Model|Eloquent $documentable
 * @property-read User|null $owner
 *
 * @method static DocumentFactory factory(...$parameters)
 * @method static Builder|Document newModelQuery()
 * @method static Builder|Document newQuery()
 * @method static Builder|Document query()
 * @method static Builder|Document whereCategory($value)
 * @method static Builder|Document whereCreatedAt($value)
 * @method static Builder|Document whereId($value)
 * @method static Builder|Document whereIsRequired($value)
 * @method static Builder|Document whereName($value)
 * @method static Builder|Document whereOwnerId($value)
 * @method static Builder|Document wherePath($value)
 * @method static Builder|Document whereState($value)
 * @method static Builder|Document whereType($value)
 * @method static Builder|Document whereUpdatedAt($value)
 * @mixin Eloquent
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

    /**
     * @retrun HasMany<Comment>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
