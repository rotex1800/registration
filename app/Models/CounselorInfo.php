<?php

namespace App\Models;

use Database\Factories\CounselorInfoFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CounselorInfo
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 * @method static CounselorInfoFactory factory(...$parameters)
 * @method static Builder|CounselorInfo newModelQuery()
 * @method static Builder|CounselorInfo newQuery()
 * @method static Builder|CounselorInfo query()
 * @method static Builder|CounselorInfo whereCreatedAt($value)
 * @method static Builder|CounselorInfo whereEmail($value)
 * @method static Builder|CounselorInfo whereId($value)
 * @method static Builder|CounselorInfo whereName($value)
 * @method static Builder|CounselorInfo wherePhone($value)
 * @method static Builder|CounselorInfo whereUpdatedAt($value)
 * @method static Builder|CounselorInfo whereUserId($value)
 * @mixin Eloquent
 */
class CounselorInfo extends Model
{
    use HasFactory;
    use PersonInfo;
    use HasCompletenessCheck;

    public function isComplete(): bool
    {
        return $this->isCompleteCheck(CounselorInfo::factory()->definition());
    }
}
