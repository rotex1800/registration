<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;

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

    public function notify(Request $request): RedirectResponse
    {
        $request->user()?->sendEmailVerificationNotification();

        return redirect(route('verification.notice'))->with(['status' => Fortify::VERIFICATION_LINK_SENT]);
    }
}
