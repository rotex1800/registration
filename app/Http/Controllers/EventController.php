<?php

namespace App\Http\Controllers;

use App\Http\Livewire\EventRegistration;
use App\Models\Event;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function show(Request $request, Event $event): View|Factory
    {
        $user = Auth::user();

        $hasRegistered = $user?->hasRegisteredFor($event) ?? false;

        $part = EventRegistration::PART_ONE;
        if ($request->filled('part')) {
            /** @var string $requestedPart */
            $requestedPart = $request->input('part');
            $input = strtolower($requestedPart);
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
}
