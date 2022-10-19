<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Policies\EventPolicy;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private EventPolicy $eventPolicy;

    public function __construct(EventPolicy $eventPolicy)
    {
        $this->eventPolicy = $eventPolicy;
    }

    public function home(): Application|Factory|View
    {
        $user = Auth::user();
        if ($user == null) {
            abort(401);
        }

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
