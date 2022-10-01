<?php

namespace App\Http\Controllers;

use App\Http\Livewire\EventRegistration;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function show(Request $request, Event $event)
    {
        $user = Auth::user();

        $hasRegistered = $user->hasRegisteredFor($event);

        $part = EventRegistration::PART_ONE;
        if ($request->filled('part')) {
            $input = strtolower($request->query('part'));

            if (in_array($input, EventRegistration::KNOWN_PARTS)) {
                $part = $input;
            }
        }

        return view('event.registration')->with([
            'event' => $event,
            'hasRegistered' => $hasRegistered,
            'part' => $part,
        ]);
    }

    public function edit(int $id)
    {
    }
}
