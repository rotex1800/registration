<?php

namespace App\Models;

use Database\Factories\ClothesInfoFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ClothesInfo
 *
 * @property int $id
 * @property string $tshirt_size
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @method static ClothesInfoFactory factory(...$parameters)
 * @method static Builder|ClothesInfo newModelQuery()
 * @method static Builder|ClothesInfo newQuery()
 * @method static Builder|ClothesInfo query()
 * @method static Builder|ClothesInfo whereCreatedAt($value)
 * @method static Builder|ClothesInfo whereId($value)
 * @method static Builder|ClothesInfo whereTshirtSize($value)
 * @method static Builder|ClothesInfo whereUpdatedAt($value)
 * @method static Builder|ClothesInfo whereUserId($value)
 *
 * @mixin Eloquent
 */
class ClothesInfo extends Model
{
    use PersonInfo;
    use HasFactory;

    protected $casts = [
        'tshirt_size' => ClothesSize::class,
    ];
}
