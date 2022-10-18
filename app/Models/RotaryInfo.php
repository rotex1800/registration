<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\RotaryInfo
 *
 * @property int $id
 * @property string|null $host_club
 * @property string|null $host_district
 * @property string|null $sponsor_club
 * @property string|null $sponsor_district
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 *
 *
 * @method static \Database\Factories\RotaryInfoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|RotaryInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RotaryInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RotaryInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|RotaryInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RotaryInfo whereHostClub($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RotaryInfo whereHostDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RotaryInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RotaryInfo whereSponsorClub($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RotaryInfo whereSponsorDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RotaryInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RotaryInfo whereUserId($value)
 * @mixin \Eloquent
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
