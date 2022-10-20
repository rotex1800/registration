<?php

use App\Models\CounselorInfo;
use App\Models\Event;
use App\Models\Passport;
use App\Models\RotaryInfo;
use App\Models\User;
use App\Models\YeoInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

test('rotex user can access registrations page', function () {
    Event::factory()->create();
    $user = createUserWithRole('rotex');
    actingAs($user)
        ->get('/registrations/1')
        ->assertSeeLivewire('main-navigation')
        ->assertOk();
});

test('other user can not access registrations page', function () {
    Event::factory()->create();
    $user = createUserWithRole('some_role');
    actingAs($user)
        ->get('/registrations/1')
        ->assertForbidden();
});

test('guest can not access registrations page', function () {
    Event::factory()->create();
    $this->get('/registrations/1')
         ->assertRedirect('/login');
});

test('contains event name', function () {
    $event = Event::factory()->create();
    $user = createUserWithRole('rotex');
    actingAs($user)
        ->get('/registrations/1')
        ->assertOk()
        ->assertSeeText($event->name);
});


it('handles users with missing data', function () {
    $user = createUserWithRole('rotex');
    $event = Event::factory()->create();
    $attendees = User::factory()
                     ->count(1)
                     ->create();
    $event->attendees()->saveMany($attendees);

    actingAs($user)
        ->get('/registrations/1')
        ->assertOk();
});


it('shows all registered attendees and their inputs', function () {
    $user = createUserWithRole('rotex');
    $event = Event::factory()->create();
    $attendees = User::factory()->count(1)
                     ->has(Passport::factory())
                     ->has(RotaryInfo::factory())
                     ->has(YeoInfo::factory(), 'yeo')
                     ->has(CounselorInfo::factory(), 'counselor')
                     ->create();
    $event->attendees()->saveMany($attendees);

    actingAs($user)
        ->get('/registrations/1')
        ->assertOk()
        ->assertSeeTextInOrder([
            __('event.registration-overview.full-name'),
            __('event.registration-overview.email'),
            __('event.registration-overview.passport'),
            __('event.registration-overview.rotary'),
            __('event.registration-overview.yeo'),
            __('event.registration-overview.counselor'),
            __('event.registration-overview.bioFamily'),
            __('event.registration-overview.hostFamily').' 1',
            __('event.registration-overview.hostFamily').' 2',
            __('event.registration-overview.hostFamily').' 3',
        ])
        ->assertSeeTextInOrder(Arr::flatten([
            'Anmeldungen',
            $event->attendees->map(function (User $attendee): array {
                $rotaryInfo = $attendee->rotaryInfo;
                $yeo = $attendee->yeo;
                $counselor = $attendee->counselor;
                return [
                    $attendee->full_name,
                    $attendee->email,

                    $attendee->passport->nationality,
                    $attendee->passport->passport_number,
                    __('registration.passport-issue-date').': '
                    .$attendee->passport->issue_date->translatedFormat('d. F Y'),
                    __('registration.passport-expiration-date').': '
                    .$attendee->passport->expiration_date->translatedFormat('d. F Y'),
                    $attendee->passport?->isComplete() ? '✅' : '⛔️',

                    "$rotaryInfo->host_club $rotaryInfo?->host_district",
                    "$rotaryInfo->sponsor_club $rotaryInfo?->sponsor_district",
                    $rotaryInfo->isComplete() ? '✅' : '⛔️',

                    $yeo?->name,
                    "Tel: $yeo?->phone",
                    "@: $yeo?->email",
                    $yeo?->isComplete() ? '✅' : '⛔️',

                    $counselor?->name,
                    "Tel: $counselor?->phone",
                    "@: $counselor?->email",
                    $counselor?->isComplete() ? '✅' : '⛔️',

                    $attendee->bioFamily?->isComplete() ? '✅' : '⛔️',
                    $attendee->firstHostFamily()?->isComplete() ? '✅' : '⛔️',
                    $attendee->secondHostFamily()?->isComplete() ? '✅' : '⛔️',
                    $attendee->thirdHostFamily()?->isComplete() ? '✅' : '⛔️',
                ];
            }),
        ]));
});

it('shows explanation text if no attendees have registered', function () {
    $user = createUserWithRole('rotex');
    Event::factory()->create();
    actingAs($user)
        ->get('/registrations/1')
        ->assertOk()
        ->assertSeeText([
            __('event.registration-overview.no-registrations'),
        ]);
});

it('requires email to be verified', function () {
    $user = User::factory()->state(['email_verified_at' => null])->create();
    Event::factory()->create();
    $this->actingAs($user)
         ->get('/registrations/1')
         ->assertRedirect(route('verification.notice'));
});
