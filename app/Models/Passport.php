<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Passport extends Model
{
    use HasFactory;
    use HasCompletnessCheck;

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
        $complete = true;
        foreach ($this->attributes as $attribute) {
            if ($attribute == null || trim($attribute) == '') {
                $complete = false;
                break;
            }
        }

        return $complete;
    }
}
