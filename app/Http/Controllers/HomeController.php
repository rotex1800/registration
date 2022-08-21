<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function home(): View
    {
        $user = Auth::user();
        $participatingEvents = $user->participatesIn();
        $registrationPossible = $user->canRegisterFor();

        return view('home', [
            'participating' => $participatingEvents,
            'registrationPossible' => $registrationPossible,
        ]);
    }
}
