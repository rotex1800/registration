<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\RegistrationComment
 *
 * @property int $id
 * @property string|null $body
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 *
 *
 * @method static \Database\Factories\RegistrationCommentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationComment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegistrationComment whereUserId($value)
 * @mixin \Eloquent
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
