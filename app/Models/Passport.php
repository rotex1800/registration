<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Passport extends Model
{
    use HasFactory;
    use HasCompletenessCheck;

    /**
     * The attributes that should be cast.
     *
     * @var array
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

    public function document(): MorphOne
    {
        return $this->morphOne(Document::class, 'documentable');
    }


}
