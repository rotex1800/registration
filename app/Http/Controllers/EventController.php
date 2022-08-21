<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function show(int $id)
    {
        $user = Auth::user();
        $event = Event::find($id);
        $hasRegistered = $user->hasRegisteredFor($event);
        return view('event.detail')->with([
            'event' => $event,
            'hasRegistered' => $hasRegistered
        ]);
    }
}
