<?php

namespace App\Models;

use App\Utils\StringUtil;
use Database\Factories\EventFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 *
 * @property-read string $short_name
 * @property-read Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 *
 * @mixin Eloquent
 */
class Event extends Model
{
    use HasFactory, HasRoles;

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    /**
     * @return Collection<User>
     */
    public function attendeesSortedByFirstName(): Collection
    {
        return $this
            ->attendees()
            ->orderBy('first_name')
            ->get();
    }

    /**
     * @phpstan-return BelongsToMany<User>
     */
    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /** @noinspection PhpUnused */
    public function getShortNameAttribute(): string
    {
        $yearComponent = $this->start?->year ?? 0;
        $nameComponent = StringUtil::firstCharacterOfEachWord($this->name);

        return $nameComponent.'-'.$yearComponent;
    }
}
