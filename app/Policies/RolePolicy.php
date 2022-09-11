<?php

namespace App\Policies;

use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RolePolicy
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
     * Indicate whether a role can be deleted
     *
     * @return Response
     */
    public function isDeletionAllowed(Role $role): Response
    {
        if ($role->users->count() > 0) {
            return Response::deny('Can not delete role with associated users');
        }

        if ($role->events->count() > 0) {
            return Response::deny('Can not delete role with associated events.');
        }

        return Response::allow();
    }
}
