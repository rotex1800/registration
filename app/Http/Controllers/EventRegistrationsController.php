<?php

namespace App\Http\Controllers;

use App\Http\Livewire\SortableTableColumn;
use App\Models\Event;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class EventRegistrationsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Event $event)
    {
        $this->authorize('seeRegistrations', Event::class);

        return view('event.registrations-overview')->with([
            'event' => $event,
            'columns' => [
                new SortableTableColumn('Name', function ($user) {
                    return $user->full_name;
                }),
                new SortableTableColumn('E-Mail', function ($user) {
                    return $user->email;
                }),
            ],
            'rows' => $event->attendees->all(),
        ]);
    }
}
