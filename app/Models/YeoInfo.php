<?php

namespace App\Models;

use Database\Factories\YeoInfoFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\YeoInfo
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @method static YeoInfoFactory factory(...$parameters)
 * @method static Builder|YeoInfo newModelQuery()
 * @method static Builder|YeoInfo newQuery()
 * @method static Builder|YeoInfo query()
 * @method static Builder|YeoInfo whereCreatedAt($value)
 * @method static Builder|YeoInfo whereEmail($value)
 * @method static Builder|YeoInfo whereId($value)
 * @method static Builder|YeoInfo whereName($value)
 * @method static Builder|YeoInfo wherePhone($value)
 * @method static Builder|YeoInfo whereUpdatedAt($value)
 * @method static Builder|YeoInfo whereUserId($value)
 * @mixin Eloquent
 */
class YeoInfo extends Model
{
    use HasFactory;
    use HasCompletenessCheck;
    use PersonInfo;

    public function isComplete(): bool
    {
        return $this->isCompleteCheck(
            YeoInfo::factory()->definition()
        );
    }
}
