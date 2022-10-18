<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\YeoInfo
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\YeoInfoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|YeoInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|YeoInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|YeoInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|YeoInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|YeoInfo whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|YeoInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|YeoInfo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|YeoInfo wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|YeoInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|YeoInfo whereUserId($value)
 * @mixin \Eloquent
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
