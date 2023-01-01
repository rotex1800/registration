<?php

namespace App\Models;

use Database\Factories\BioFamilyFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\BioFamily
 *
 * @property int $id
 * @property string|null $parent_one
 * @property string|null $parent_two
 * @property string|null $phone
 * @property string|null $email
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static BioFamilyFactory factory(...$parameters)
 * @method static Builder|BioFamily newModelQuery()
 * @method static Builder|BioFamily newQuery()
 * @method static Builder|BioFamily query()
 * @method static Builder|BioFamily whereCreatedAt($value)
 * @method static Builder|BioFamily whereEmail($value)
 * @method static Builder|BioFamily whereId($value)
 * @method static Builder|BioFamily whereParentOne($value)
 * @method static Builder|BioFamily whereParentTwo($value)
 * @method static Builder|BioFamily wherePhone($value)
 * @method static Builder|BioFamily whereUpdatedAt($value)
 * @method static Builder|BioFamily whereUserId($value)
 * @mixin Eloquent
 */
class BioFamily extends Model
{
    use HasFactory, HasCompletenessCheck;

    public function isComplete(): bool
    {
        return $this->isCompleteCheck(BioFamily::factory()->definition());
    }
}
