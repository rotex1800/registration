<?php

namespace App\Policies;

use App\Models\HasRoles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Authenticatable;

class PaymentPolicy
{
    use HandlesAuthorization;

    public function createPayment(?Authenticatable $authenticatable): Response
    {
        if (
            $authenticatable == null
            || ! in_array(HasRoles::class, class_uses_recursive($authenticatable))
        ) {
            return $this->deny();
        }

        $user = User::whereId($authenticatable->getAuthIdentifier())
            ->first();
        if ($user == null || ! $user->hasRole('rotex')) {
            return $this->deny();
        }

        return $this->allow();
    }
}
