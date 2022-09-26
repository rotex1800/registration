<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Event[] $events
 * @property-read int|null $events_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 *
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereTwoFactorConfirmedAt($value)
 * @method static Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static Builder|User whereTwoFactorSecret($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date:Y-m-d',
    ];

    /**
     * Checks whether the user has registered for the given event.
     *
     * @param  Event  $event
     * @return bool
     */
    public function hasRegisteredFor(Event $event): bool
    {
        return $this->events()->get()->contains($event);
    }

    /**
     * @return BelongsToMany
     * @phpstan-return BelongsToMany<Event>
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    /**
     * @return HasMany
     * @phpstan-return HasMany<Comment>
     */
    public function authoredComments(): HasMany
    {
        return $this->hasMany(Comment::class, 'author_id');
    }

    /**
     * @return HasMany
     * @phpstan-return HasMany<Document>
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'owner_id');
    }

    /**
     * @return HasOne
     * @phpstan-return HasOne<Passport>
     */
    public function passport(): HasOne
    {
        return $this->hasOne(Passport::class, 'user_id');
    }

    /**
     * @retrun HasOne
     * @phpstan-return HasOne<CounselorInfo>
     */
    public function counselor(): HasOne
    {
        return $this->hasOne(CounselorInfo::class, 'user_id');
    }

    /**
     * @retrun HasOne
     * @phpstan-return HasOne<YeoInfo>
     */
    public function yeo(): HasOne
    {
        return $this->hasOne(YeoInfo::class, 'user_id');
    }

    /**
     * @retrun HasOne
     * @phpstan-return HasOne<RotaryInfo>
     */
    public function rotaryInfo(): HasOne
    {
        return $this->hasOne(RotaryInfo::class, 'user_id');
    }

    /**
     * @retrun HasOne
     * @phpstan-return HasOne<BioFamily>
     */
    public function bioFamily(): HasOne
    {
        return $this->hasOne(BioFamily::class, 'user_id');
    }

    public function firstHostFamily(): ?HostFamily
    {
        return $this->hostFamily(1);
    }

    public function hostFamily(int $order): HostFamily
    {
        $familyOrNull = $this
            ->hostFamilies()
            ->order($order)
            ->get()
            ->first();
        if ($familyOrNull == null) {
            $familyOrNull = HostFamily::factory()->empty()->nth($order)->make();
        }

        return $familyOrNull;
    }

    /**
     * @return HasMany
     * @phpstan-return HasMany<HostFamily>
     */
    public function hostFamilies(): HasMany
    {
        return $this->hasMany(HostFamily::class, 'user_id');
    }

    public function secondHostFamily(): ?HostFamily
    {
        return $this->hostFamily(2);
    }

    public function thirdHostFamily(): ?HostFamily
    {
        return $this->hostFamily(3);
    }

    /**
     * @param  Document  $document
     * @return bool
     */
    public function owns(Document $document): bool
    {
        return $document->owner->id == $this->id;
    }

    /**
     * Indicates whether the user has a role of the given name
     *
     * @param  string  $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->get()->count() > 0;
    }

    /**
     * @return BelongsToMany
     * @phpstan-return BelongsToMany<Role>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return Collection
     * @phpstan-return Collection<Event>
     */
    public function canRegisterFor(): Collection
    {
        return $this->possibleEvents()
                    ->diff($this->participatesIn());
    }

    /**
     * All events that the user shares at least one role with.
     *
     * @return Collection
     * @phpstan-return Collection<Event>
     */
    public function possibleEvents(): Collection
    {
        $roleIds = $this->roles()->allRelatedIds();

        return Event::whereHas(
            'roles',
            function (Builder $q) use ($roleIds) {
                $q->whereIn('id', $roleIds);
            }
        )->get();
    }

    /**
     * @return Collection
     * @phpstan-return Collection<Event>
     */
    public function participatesIn(): Collection
    {
        return $this->events()->get();
    }
}
