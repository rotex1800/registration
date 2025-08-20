<?php

namespace App\Models;

use Database\Factories\PaymentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property float $amount
 * @property int $event_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Event|null $event
 * @property-read User|null $user
 *
 * @method static PaymentFactory factory(...$parameters)
 * @method static Builder|Payment newModelQuery()
 * @method static Builder|Payment newQuery()
 * @method static Builder|Payment query()
 * @method static Builder|Payment whereAmount($value)
 * @method static Builder|Payment whereCreatedAt($value)
 * @method static Builder|Payment whereEventId($value)
 * @method static Builder|Payment whereId($value)
 * @method static Builder|Payment whereUpdatedAt($value)
 * @method static Builder|Payment whereUserId($value)
 *
 * @mixin Eloquent
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
    ];

    /**
     * @return BelongsTo<User, Payment>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Event, Payment>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
