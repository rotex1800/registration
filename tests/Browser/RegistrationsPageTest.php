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

it('shows the sum of registrations', function () {
    $user = createUserWithRole('rotex');
    $event = Event::factory()
                  ->has(User::factory()->count(5), 'attendees')
                  ->create();
    actingAs($user)
        ->get(route('registrations.show', $event))
        ->assertStatus(200)
        ->assertSeeText('Anmeldungen: 5');
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
        ->assertOk()
        ->assertSeeLivewire('registration-info-view')
        ->assertSee($attendees->first()->full_name, escape: false);
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

it('contains component to add new payments', function () {
    $user = createUserWithRole('rotex');

    $event = Event::factory()->create();
    $attendees = User::factory()->count(10)->make();
    $event->attendees()->saveMany($attendees);

    Event::factory()->create();
    actingAs($user)
        ->get('/registrations/1')
        ->assertOk()
        ->assertSeeLivewire('add-payment');
});

it('contains component to add new note', function () {
    $user = createUserWithRole('rotex');
    $event = Event::factory()->create();
    $attendee = User::factory()->make();
    $event->attendees()->save($attendee);
    actingAs($user)
        ->get('/registrations/1')
        ->assertOk()
        ->assertSeeLivewire('add-note');
});
