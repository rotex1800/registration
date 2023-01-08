<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PaymentPolicy
{
    use HandlesAuthorization;

    public function createPayment(?User $user): Response
    {
        if ($user == null || ! $user->hasRole('rotex')) {
            return $this->deny();
        }

        return $this->allow();
    }
}
