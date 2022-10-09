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
            'columns' => $this->tableColumns(),
            'rows' => $event->attendees->all(),
            'extraRowLivewire' => 'documents-rater',
        ]);
    }

    /**
     * @return array
     */
    private function tableColumns(): array
    {
        return [
            new SortableTableColumn(__('event.registration-overview.full-name'), function ($user) {
                return $user->full_name;
            }),
            new SortableTableColumn(__('event.registration-overview.email'), function ($user) {
                return $user->email;
            }),
            new SortableTableColumn(__('event.registration-overview.passport'), function ($user) {
                return $user->passport?->isComplete() ? '✅' : '⛔️';
            }),
            new SortableTableColumn(__('event.registration-overview.rotary'), function ($user) {
                return $user->passport?->isComplete() ? '✅' : '⛔️';
            }),
            new SortableTableColumn(__('event.registration-overview.yeo'), function ($user) {
                return $user->yeo?->isComplete() ? '✅' : '⛔️';
            }),
            new SortableTableColumn(__('event.registration-overview.counselor'), function ($user) {
                return $user->counselor?->isComplete() ? '✅' : '⛔️';
            }),
            new SortableTableColumn(__('event.registration-overview.bioFamily'), function ($user) {
                return $user->bioFamily?->isComplete() ? '✅' : '⛔️';
            }),
            new SortableTableColumn(__('event.registration-overview.hostFamily').' 1', function ($user) {
                return $user->firstHostFamily()?->isComplete() ? '✅' : '⛔️';
            }),
            new SortableTableColumn(__('event.registration-overview.hostFamily').' 2', function ($user) {
                return $user->secondHostFamily()?->isComplete() ? '✅' : '⛔️';
            }),
            new SortableTableColumn(__('event.registration-overview.hostFamily').' 3', function ($user) {
                return $user->thirdHostFamily()?->isComplete() ? '✅' : '⛔️';
            }),
        ];
    }
}
