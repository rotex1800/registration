<?php

namespace App\Models;

use Database\Factories\CommentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Comment
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $author_id
 * @property string $content
 * @property-read User|null $author
 *
 * @method static CommentFactory factory(...$parameters)
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static Builder|Comment query()
 * @method static Builder|Comment whereAuthorId($value)
 * @method static Builder|Comment whereContent($value)
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 *
 * @property int|null $document_id
 *
 * @method static Builder|Comment whereDocumentId($value)
 *
 * @mixin Eloquent
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'content',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
