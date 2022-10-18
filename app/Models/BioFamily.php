<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BioFamily
 *
 * @property int $id
 * @property string|null $parent_one
 * @property string|null $parent_two
 * @property string|null $phone
 * @property string|null $email
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\BioFamilyFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|BioFamily newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BioFamily newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BioFamily query()
 * @method static \Illuminate\Database\Eloquent\Builder|BioFamily whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BioFamily whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BioFamily whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BioFamily whereParentOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BioFamily whereParentTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BioFamily wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BioFamily whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BioFamily whereUserId($value)
 * @mixin \Eloquent
 */
class BioFamily extends Model
{
    use HasFactory, HasCompletenessCheck;

    public function isComplete(): bool
    {
        return $this->isCompleteCheck(BioFamily::factory()->definition());
    }
}
