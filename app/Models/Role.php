<?php

namespace App\Models;

use Database\Factories\RoleFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property-read Collection|Event[] $events
 * @property-read int|null $events_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 *
 * @method static RoleFactory factory(...$parameters)
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * @return BelongsToMany
     * @phpstan-return BelongsToMany<User>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return BelongsToMany
     * @phpstan-return BelongsToMany<Event>
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
