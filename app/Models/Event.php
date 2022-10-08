<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $start
 * @property Carbon|null $end
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|User[] $attendees
 * @property-read int|null $attendees_count
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 *
 * @method static EventFactory factory(...$parameters)
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event query()
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereEnd($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereName($value)
 * @method static Builder|Event whereStart($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Event extends Model
{
    use HasFactory, HasCompletenessCheck, HasRoles;

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    /**
     * @return BelongsToMany
     * @phpstan-return BelongsToMany<User>
     */
    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function isComplete(): bool
    {
        return $this->isCompleteCheck([
            'name',
            'start',
            'end',
        ]);
    }
}
