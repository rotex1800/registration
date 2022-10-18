<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CounselorInfo
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\CounselorInfoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CounselorInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CounselorInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CounselorInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|CounselorInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounselorInfo whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounselorInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounselorInfo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounselorInfo wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounselorInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounselorInfo whereUserId($value)
 * @mixin \Eloquent
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
