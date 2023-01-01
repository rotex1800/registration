<?php

namespace App\Models;

use Database\Factories\PassportFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Passport
 *
 * @property int $id
 * @property string|null $nationality
 * @property string|null $passport_number
 * @property Carbon|null $issue_date
 * @property Carbon|null $expiration_date
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @method static PassportFactory factory(...$parameters)
 * @method static Builder|Passport newModelQuery()
 * @method static Builder|Passport newQuery()
 * @method static Builder|Passport query()
 * @method static Builder|Passport whereCreatedAt($value)
 * @method static Builder|Passport whereExpirationDate($value)
 * @method static Builder|Passport whereId($value)
 * @method static Builder|Passport whereIssueDate($value)
 * @method static Builder|Passport whereNationality($value)
 * @method static Builder|Passport wherePassportNumber($value)
 * @method static Builder|Passport whereUpdatedAt($value)
 * @method static Builder|Passport whereUserId($value)
 *
 * @mixin Eloquent
 */
class Passport extends Model
{
    use HasFactory;
    use HasCompletenessCheck;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'issue_date' => 'date:Y-m-d',
        'expiration_date' => 'date:Y-m-d',
        'passport_number' => 'string',
        'nationality' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isComplete(): bool
    {
        return $this->isCompleteCheck(Passport::factory()->definition());
    }
}
