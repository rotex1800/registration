<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Authenticatable;

class NotePolicy
{
    use HandlesAuthorization;

    public function createNote(?Authenticatable $authenticatable): Response
    {
        return $this->allowAuthenticatedRotexUser($authenticatable);
    }

    private function allowAuthenticatedRotexUser(?Authenticatable $authenticatable): Response
    {
        if ($authenticatable == null) {
            return Response::deny();
        }
        $id = intval($authenticatable->getAuthIdentifier());
        $user = User::find($id);
        if ($user != null && $user->hasRole('rotex')) {
            return Response::allow();
        } else {
            return Response::deny();
        }
    }

    public function readNote(?Authenticatable $authenticatable): Response
    {
        return $this->allowAuthenticatedRotexUser($authenticatable);
    }
}
