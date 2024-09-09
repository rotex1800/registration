<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Indicate whether the given user is allowed to edit an event.
     */
    public function canEditEvent(?User $user): Response
    {
        if ($user == null) {
            return Response::deny(
                'Unknown user is not allowed to edit an event.'
            );
        }

        if ($user->hasRole('rotex')) {
            return Response::allow();
        }

        return Response::deny(
            'User does not have correct role to edit an event'
        );
    }

    /**
     * Determine whether the given user can see the given event
     */
    public function show(?User $user, Event $event): Response
    {
        if ($user == null) {
            return Response::deny('Guests are not allowed to see events');
        }
        $events = $user->possibleEvents();

        if ($events->doesntContain($event)) {
            return Response::deny();
        }

        return Response::allow();
    }

    /**
     * Determine whether the given user can see the registrations for the given event.
     */
    public function seeRegistrations(?User $user): Response
    {
        if ($user == null) {
            return Response::deny();
        }

        if ($user->hasRole('rotex')) {
            return Response::allow();
        }

        return Response::deny();
    }
}
