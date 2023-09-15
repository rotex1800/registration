<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(Request $request, string $id, string $hash): void
    {
        $user = User::find($id);
        $email = $user?->email;
        if ($email != null && hash_equals(sha1($email), $hash)) {
            $user->markEmailAsVerified();
        }
    }

    public function notify(Request $request): void
    {
        $request->user()?->sendEmailVerificationNotification();
    }
}
