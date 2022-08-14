<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function home(): View
    {
        $user = Auth::user();
        $events = $user?->events()->get();
        $userRoles = $user->roles()->allRelatedIds();

        $otherEventsBuilder = Event::whereHas(
            'roles', function (Builder $q) use ($userRoles) {
                $q->whereIn('id', $userRoles);
        });
        $otherEvents = $otherEventsBuilder->get();

        return view('home', [
            'events' => $events,
            'otherEvents' => $otherEvents,
        ]);
    }
}
