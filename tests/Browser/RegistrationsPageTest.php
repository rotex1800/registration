<?php

use App\Models\Event;
use App\Models\User;
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

it('shows all registered attendees', function () {
    $user = createUserWithRole('rotex');
    $event = Event::factory()->create();
    $attendees = User::factory()->count(10)->make();
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
            $event->attendees->map(function ($elem): array {
                return [
                    $elem->full_name,
                    $elem->email,
                    $elem->passport?->isComplete() ? '✅' : '⛔️',
                    $elem->rotaryInfo?->isComplete() ? '✅' : '⛔️',
                    $elem->yeo?->isComplete() ? '✅' : '⛔️',
                    $elem->counselor?->isComplete() ? '✅' : '⛔️',
                    $elem->bioFamily?->isComplete() ? '✅' : '⛔️',
                    $elem->firstHostFamily()?->isComplete() ? '✅' : '⛔️',
                    $elem->secondHostFamily()?->isComplete() ? '✅' : '⛔️',
                    $elem->thirdHostFamily()?->isComplete() ? '✅' : '⛔️',
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

it('requires email to be verfied', function () {
    $user = User::factory()->state(['email_verified_at' => null])->create();
    Event::factory()->create();
    $this->actingAs($user)
         ->get('/registrations/1')
         ->assertRedirect(route('verification.notice'));
});
