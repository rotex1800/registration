<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Policies\EventPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    private EventPolicy $eventPolicy;

    public function __construct(EventPolicy $eventPolicy)
    {
        $this->eventPolicy = $eventPolicy;
    }

    public function home(): View
    {
        $user = Auth::user();
        $participatingEvents = $user->participatesIn();
        $registrationPossible = $user->canRegisterFor();
        $canSeeRegistrations = $this->eventPolicy->seeRegistrations($user);
        $allEvents = Event::all();

        return view('home', [
            'participating' => $participatingEvents,
            'registrationPossible' => $registrationPossible,
            'canSeeRegistrations' => $canSeeRegistrations,
            'allEvents' => $allEvents,
        ]);
    }
}
