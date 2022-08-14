<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function show(int $id)
    {
        $event = Event::find($id);
        return view('event.detail')->with('event', $event);
    }
}
