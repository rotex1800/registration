<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EventRegistrationsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Event $event): View|Factory
    {
        $this->authorize('seeRegistrations', Event::class);

        return view('event.registrations-overview')->with([
            'event' => $event,
        ]);
    }
}
