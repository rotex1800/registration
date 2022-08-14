<?php

namespace App\Http\Controllers;

use App\Service\EventService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{

    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }


    public function home(): View
    {
        $user = Auth::user();
        $participatingEvents = $this->eventService->participating($user);
        $registrationPossible = $this->eventService->registrationPossible($user);

        return view('home', [
            'participating' => $participatingEvents,
            'registrationPossible' => $registrationPossible,
        ]);
    }
}
