<?php

namespace App\Models;

use App\Utils\StringUtil;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
 *
 * @mixin Eloquent
 */

/**
 * App\Models\User
 *
 * @uses \Illuminate\Auth\MustVerifyEmail
 *
 * @property int $id
 * @property string $first_name
 * @property string $family_name
 * @property Carbon|null $birthday
 * @property string|null $gender
 * @property string|null $mobile_phone
 * @property string|null $health_issues
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $uuid
 * @property-read Collection|Comment[] $authoredComments
 * @property-read int|null $authored_comments_count
 * @property-read BioFamily|null $bioFamily
 * @property-read CounselorInfo|null $counselor
 * @property-read Collection|Document[] $documents
 * @property-read int|null $documents_count
 * @property-read Collection|Event[] $events
 * @property-read int|null $events_count
 * @property-read Collection|HostFamily[] $hostFamilies
 * @property-read int|null $host_families_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Passport|null $passport
 * @property-read RegistrationComment|null $registrationComment
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @property-read RotaryInfo|null $rotaryInfo
 * @property-read YeoInfo|null $yeo
 * @property-read string $full_name
 *
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereBirthday($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFamilyName($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereGender($value)
 * @method static Builder|User whereHealthIssues($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereMobilePhone($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static Builder|User whereTwoFactorSecret($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUuid($value)
 *
 * @mixin Eloquent
 *
 * @property-read AdditionalInfo|null $additionalInfo
 * @property-read string $comment_display_name
 * @property-read string $short_name
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasCompletenessCheck, HasRoles, HasDocuments, \Illuminate\Auth\MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'first_name',
        'family_name',
        'email',
        'password',
        'uuid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date:Y-m-d',
    ];

    /**
     * Accessor combining first name and family name
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->family_name;
    }

    /**
     * Accessor for the display name used in comments
     * Returns the full_name for normal users, and "Rotex 1800" for 'rotex'
     * users
     */
    public function getCommentDisplayNameAttribute(): string
    {
        if ($this->hasRole('rotex')) {
            return 'Rotex 1800';
        }

        return $this->full_name;
    }

    /**
     *; @return HasOne
     *
     * @phpstan-return HasOne<Passport>
     */
    public function passport(): HasOne
    {
        return $this->hasOne(Passport::class, 'user_id');
    }

    /**
     * Checks whether the user has registered for the given event.
     *
     * @param  Event  $event
     * @return bool
     */
    public function hasRegisteredFor(Event $event): bool
    {
        return $this->events()->where('id', $event->id)->exists();
    }

    /**
     * @return BelongsToMany
     *
     * @phpstan-return BelongsToMany<Event>
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    /**
     * @return HasMany
     *
     * @phpstan-return HasMany<Comment>
     */
    public function authoredComments(): HasMany
    {
        return $this->hasMany(Comment::class, 'author_id');
    }

    public function registrationComment(): HasOne
    {
        return $this->hasOne(RegistrationComment::class);
    }

    /**
     * @retrun HasOne
     *
     * @phpstan-return HasOne<CounselorInfo>
     */
    public function counselor(): HasOne
    {
        return $this->hasOne(CounselorInfo::class, 'user_id');
    }

    /**
     * @retrun HasOne
     *
     * @phpstan-return HasOne<YeoInfo>
     */
    public function yeo(): HasOne
    {
        return $this->hasOne(YeoInfo::class, 'user_id');
    }

    /**
     * @retrun HasOne
     *
     * @phpstan-return HasOne<RotaryInfo>
     */
    public function rotaryInfo(): HasOne
    {
        return $this->hasOne(RotaryInfo::class, 'user_id');
    }

    /**
     * @retrun HasOne
     *
     * @phpstan-return HasOne<BioFamily>
     */
    public function bioFamily(): HasOne
    {
        return $this->hasOne(BioFamily::class, 'user_id');
    }

    /**
     * @return HasOne<AdditionalInfo>
     */
    public function additionalInfo(): HasOne
    {
        return $this->hasOne(AdditionalInfo::class, 'user_id');
    }

    public function firstHostFamily(): HostFamily
    {
        return $this->hostFamily(1);
    }

    /**
     * @param  int  $order
     * @return HostFamily
     */
    public function hostFamily(int $order): HostFamily
    {
        $familyOrNull = $this
            ->hostFamilies()
            ->order($order)
            ->first();

        if ($familyOrNull != null) {
            return $familyOrNull;
        }

        return HostFamily::factory()->empty()->nth($order)->make();
    }

    /**
     * @return HasMany
     *
     * @phpstan-return HasMany<HostFamily>
     */
    public function hostFamilies(): HasMany
    {
        return $this->hasMany(HostFamily::class, 'user_id');
    }

    public function secondHostFamily(): HostFamily
    {
        return $this->hostFamily(2);
    }

    public function thirdHostFamily(): HostFamily
    {
        return $this->hostFamily(3);
    }

    /**
     * @return Collection
     *
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
     *
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
     *
     * @phpstan-return Collection<Event>
     */
    public function participatesIn(): Collection
    {
        return $this->events()->get();
    }

    public function isComplete(): bool
    {
        return
            $this->notBlankOrEmpty($this->first_name)
            && $this->notBlankOrEmpty($this->family_name)
            && $this->notBlankOrEmpty($this->birthday)
            && $this->notBlankOrEmpty($this->gender)
            && $this->notBlankOrEmpty($this->mobile_phone)
            && (
                $this->notBlankOrEmpty($this->additionalInfo?->tshirt_size->value ?? '')
                && ($this->additionalInfo?->tshirt_size ?? ClothesSize::NA) != ClothesSize::NA
            )
            && $this->notBlankOrEmpty($this->health_issues);
    }

    /** @noinspection PhpUnused */
    private function notBlankOrEmpty(?string $value): bool
    {
        return $value != null && trim($value) != '';
    }

    public function getShortNameAttribute(): string
    {
        $birthdayComponent = $this->birthday?->translatedFormat('dm') ?? 'XXXX';
        $nameComponent = StringUtil::firstCharacterOfEachWord($this->full_name);

        return $nameComponent.'-'.$birthdayComponent;
    }

    public function overallDocumentState(): DocumentState
    {
        $docStates = [];
        foreach (DocumentCategory::validCategories() as $category) {
            $docStates[] = $this->documentBy($category)->state ?? DocumentState::Missing;
        }

        $docStates = DocumentState::sort($docStates);

        return $docStates[0];
    }
}
