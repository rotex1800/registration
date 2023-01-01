<?php

namespace App\Models;

use Database\Factories\RotaryInfoFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\RotaryInfo
 *
 * @property int $id
 * @property string|null $host_club
 * @property string|null $host_district
 * @property string|null $sponsor_club
 * @property string|null $sponsor_district
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 * @method static RotaryInfoFactory factory(...$parameters)
 * @method static Builder|RotaryInfo newModelQuery()
 * @method static Builder|RotaryInfo newQuery()
 * @method static Builder|RotaryInfo query()
 * @method static Builder|RotaryInfo whereCreatedAt($value)
 * @method static Builder|RotaryInfo whereHostClub($value)
 * @method static Builder|RotaryInfo whereHostDistrict($value)
 * @method static Builder|RotaryInfo whereId($value)
 * @method static Builder|RotaryInfo whereSponsorClub($value)
 * @method static Builder|RotaryInfo whereSponsorDistrict($value)
 * @method static Builder|RotaryInfo whereUpdatedAt($value)
 * @method static Builder|RotaryInfo whereUserId($value)
 * @mixin Eloquent
 */
class RotaryInfo extends Model
{
    use HasFactory, HasCompletenessCheck;

    /**
     * Inverse of the one-to-one relation between a user and RotaryInfo
     *
     *
     * @return BelongsTo<User, RotaryInfo>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isComplete(): bool
    {
        return $this->isCompleteCheck(RotaryInfo::factory()->definition());
    }
}
