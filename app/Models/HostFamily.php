<?php

namespace App\Models;

use Database\Factories\HostFamilyFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\HostFamily
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property int|null $user_id
 * @property int|null $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $inbound
 *
 * @method static Builder|HostFamily newModelQuery()
 * @method static Builder|HostFamily newQuery()
 * @method static Builder|HostFamily order(int $order)
 * @method static Builder|HostFamily query()
 * @method static Builder|HostFamily whereAddress($value)
 * @method static Builder|HostFamily whereCreatedAt($value)
 * @method static Builder|HostFamily whereEmail($value)
 * @method static Builder|HostFamily whereId($value)
 * @method static Builder|HostFamily whereName($value)
 * @method static Builder|HostFamily whereOrder($value)
 * @method static Builder|HostFamily wherePhone($value)
 * @method static Builder|HostFamily whereUpdatedAt($value)
 * @method static Builder|HostFamily whereUserId($value)
 * @method static HostFamilyFactory factory(...$parameters)
 *
 * @mixin Eloquent
 */
class HostFamily extends Model
{
    use HasCompletenessCheck, HasFactory;

    public function inbound(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeOrder(Builder $builder, int $order): Builder
    {
        return $builder->where('order', $order);
    }

    public function isComplete(): bool
    {
        return $this->isCompleteCheck(HostFamily::factory()->definition());
    }
}
