<?php

use App\Models\BioFamily;
use App\Models\CounselorInfo;
use App\Models\Event;
use App\Models\HostFamily;
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

test('contains download link', function () {
    // Arrange
    $event = Event::factory()
                  ->has(User::factory()->count(3), 'attendees')
                  ->create();

    $user = createUserWithRole('rotex');

    // Act & Assert
    actingAs($user)
        ->get('/registrations/1')
        ->assertOk()
        ->assertSeeText('Download');
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
    $attendees = User::factory()->count(10)
                     ->has(Passport::factory())
                     ->has(RotaryInfo::factory())
                     ->has(YeoInfo::factory(), 'yeo')
                     ->has(CounselorInfo::factory(), 'counselor')
                     ->has(BioFamily::factory())
                     ->has(HostFamily::factory()->nth(1))
                     ->has(HostFamily::factory()->nth(2))
                     ->has(HostFamily::factory()->nth(3))
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

                $bioFamily = $attendee->bioFamily;
                $firstHostFamily = $attendee->firstHostFamily();
                $secondHostFamily = $attendee->secondHostFamily();
                $thirdHostFamily = $attendee->thirdHostFamily();

                return [
                    $attendee->full_name,
                    $attendee->email,

                    $attendee->passport?->nationality,
                    $attendee->passport?->passport_number,
                    __('registration.passport-issue-date').': '
                    .$attendee->passport?->issue_date?->translatedFormat('d. F Y'),
                    __('registration.passport-expiration-date').': '
                    .$attendee->passport?->expiration_date?->translatedFormat('d. F Y'),
                    $attendee->passport?->isComplete() ? '✅' : '⛔️',

                    "$rotaryInfo?->host_club $rotaryInfo?->host_district",
                    "$rotaryInfo?->sponsor_club $rotaryInfo?->sponsor_district",
                    $rotaryInfo?->isComplete() ? '✅' : '⛔️',

                    $yeo?->name,
                    "Tel: $yeo?->phone",
                    "@: $yeo?->email",
                    $yeo?->isComplete() ? '✅' : '⛔️',

                    $counselor?->name,
                    "Tel: $counselor?->phone",
                    "@: $counselor?->email",
                    $counselor?->isComplete() ? '✅' : '⛔️',

                    $bioFamily?->parent_one,
                    $bioFamily?->parent_two,
                    $bioFamily?->email,
                    $bioFamily?->phone,
                    $bioFamily?->isComplete() ? '✅' : '⛔️',

                    $firstHostFamily->name,
                    $firstHostFamily->email,
                    $firstHostFamily->phone,
                    $firstHostFamily->address,
                    $firstHostFamily->isComplete() ? '✅' : '⛔️',

                    $secondHostFamily->name,
                    $secondHostFamily->email,
                    $secondHostFamily->phone,
                    $secondHostFamily->address,
                    $secondHostFamily->isComplete() ? '✅' : '⛔️',

                    $thirdHostFamily->name,
                    $thirdHostFamily->email,
                    $thirdHostFamily->phone,
                    $thirdHostFamily->address,
                    $thirdHostFamily->isComplete() ? '✅' : '⛔️',
                ];
            }),
        ]), escape: false);
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
