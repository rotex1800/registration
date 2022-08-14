<?php

namespace App\Service;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EventService
{

    /**
     * @param User $user
     * @return Collection
     * @phpstan-return Collection<Event>
     */
    public function participating(User $user): Collection
    {
        return $user?->events()->get();
    }

    public function registrationPossible(User $user): Collection
    {
        $roleIds = $user->roles()->allRelatedIds();
        return Event::whereHas(
            'roles', function (Builder $q) use ($roleIds) {
            $q->whereIn('id', $roleIds);
        })->get();
    }


}
