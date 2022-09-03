<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DocumentPolicy
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

    public function canApprove(User $user): Response
    {
        return $user->hasRole('rotex') ?
        Response::allow() :
        Response::deny('You are not allowed to approve this document');
    }

}
