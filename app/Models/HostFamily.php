<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HostFamily extends Model
{
    use HasFactory;

    public function inbound(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeOrder(Builder $builder, $order): Builder
    {
        return $builder->where('order', $order);
    }
}
