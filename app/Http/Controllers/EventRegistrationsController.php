<?php

namespace App\Http\Controllers;

use App\Http\Livewire\SortableTableColumn;
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
            'columns' => $this->tableColumns(),
            'rows' => $event->attendees->all(),
            'extraRowLivewire' => 'documents-table-row',
        ]);
    }

    /**
     * @return array<SortableTableColumn>
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
            $this->getPassportColumn(),
            $this->getRotaryColumn(),
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

    /**
     * @return SortableTableColumn
     */
    private function getPassportColumn(): SortableTableColumn
    {
        return new SortableTableColumn(__('event.registration-overview.passport'), function ($user) {
            $passport = $user->passport;
            $nationality = $passport->nationality;
            $passportNumber = $passport->passport_number;
            $issueDate = __('registration.passport-issue-date').': '
                .$passport->issue_date->translatedFormat('d. F Y');
            $expirationDate = __('registration.passport-expiration-date').': '
                .$passport->expiration_date->translatedFormat('d. F Y');
            $completeness = $passport->isComplete() ? '✅' : '⛔️';
            return $nationality.'<br>'.$passportNumber.'<br>'.$issueDate.'<br>'.$expirationDate.'<br>'.$completeness;
        });
    }

    /**
     * @return SortableTableColumn
     */
    private function getRotaryColumn(): SortableTableColumn
    {
        return new SortableTableColumn(__('event.registration-overview.rotary'), function ($user) {
            $rotaryInfo = $user->rotaryInfo;

            $hostClub = $rotaryInfo?->host_club ?? '';
            $hostDistrict = $rotaryInfo?->host_district ?? '';

            $sponsorClub = $rotaryInfo?->sponsor_club ?? '';
            $sponsorDistrict = $rotaryInfo?->sponsor_district ?? '';

            $completeness = $user->passport?->isComplete() ? '✅' : '⛔️';

            return "$hostClub $hostDistrict<br>$sponsorClub $sponsorDistrict<br>$completeness";
        });
    }
}
