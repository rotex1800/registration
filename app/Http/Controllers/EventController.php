<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function show(Event $event)
    {
        $user = Auth::user();

        $hasRegistered = $user->hasRegisteredFor($event);
        return view('event.registration')->with([
            'event' => $event,
            'hasRegistered' => $hasRegistered,
        ]);
    }

    public function edit(int $id)
    {
    }
}
