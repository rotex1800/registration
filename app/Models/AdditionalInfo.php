<?php

namespace App\Models;

use Database\Factories\AdditionalInfoFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\AdditionalInfo
 *
 * @property int $id
 * @property ClothesSize $tshirt_size
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @method static AdditionalInfoFactory factory(...$parameters)
 * @method static Builder|AdditionalInfo newModelQuery()
 * @method static Builder|AdditionalInfo newQuery()
 * @method static Builder|AdditionalInfo query()
 * @method static Builder|AdditionalInfo whereCreatedAt($value)
 * @method static Builder|AdditionalInfo whereId($value)
 * @method static Builder|AdditionalInfo whereTshirtSize($value)
 * @method static Builder|AdditionalInfo whereUpdatedAt($value)
 * @method static Builder|AdditionalInfo whereUserId($value)
 *
 * @property string|null $allergies
 *
 * @method static Builder|AdditionalInfo whereAllergies($value)
 *
 * @property string $diet
 *
 * @method static Builder|AdditionalInfo whereDiet($value)
 *
 * @property string|null $note
 *
 * @method static Builder|AdditionalInfo whereNote($value)
 *
 * @mixin Eloquent
 */
class AdditionalInfo extends Model
{
    use HasComments;

    use HasFactory;

    /** @use PersonInfo<AdditionalInfo> */
    use PersonInfo;

    protected $casts = [
        'tshirt_size' => ClothesSize::class,
    ];

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
