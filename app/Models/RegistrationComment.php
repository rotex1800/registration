<?php

namespace App\Models;

use Database\Factories\RegistrationCommentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\RegistrationComment
 *
 * @property int $id
 * @property string|null $body
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @method static RegistrationCommentFactory factory(...$parameters)
 * @method static Builder|RegistrationComment newModelQuery()
 * @method static Builder|RegistrationComment newQuery()
 * @method static Builder|RegistrationComment query()
 * @method static Builder|RegistrationComment whereBody($value)
 * @method static Builder|RegistrationComment whereCreatedAt($value)
 * @method static Builder|RegistrationComment whereId($value)
 * @method static Builder|RegistrationComment whereUpdatedAt($value)
 * @method static Builder|RegistrationComment whereUserId($value)
 *
 * @mixin Eloquent
 */
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
