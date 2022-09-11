<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommentPolicy
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

    public function userCanCommentDocument(User $user, Document $document): Response
    {
        if ($user->hasRole('rotex')) {
            return Response::allow();
        }

        if ($user->hasRole('participant')) {
            return $user->owns($document)
            ? Response::allow()
            : Response::deny('Participants can only comment on documents they own.');
        }

        return Response::deny('User has unknown role');
    }
}
