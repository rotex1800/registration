<?php

use App\Models\Event;
use App\Models\Role;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('shows main navigation', function () {
    $role = Role::factory()
                ->has(User::factory())
                ->has(Event::factory())
                ->create();
    $user = $role->users[0];
    $event = $role->events[0];

    actingAs($user)
        ->get("/event/$event->id")
        ->assertStatus(200)
        ->assertSeeLivewire('main-navigation');
});

it('is not accessible when logged out', function () {
    $event = Event::factory()->create();
    $this->get("/event/$event->id")
         ->assertRedirect('/login');
});

test('event details are not available for mismatching roles', function () {
    $role = Role::factory()->count(2)
                ->has(User::factory())
                ->has(Event::factory())
                ->create();
    $user = $role[0]->users[0];
    $event = $role[1]->events[0];

    actingAs($user)
        ->get("/event/$event->id")
        ->assertStatus(403);
});

it('shows event details component', function () {
    $role = Role::factory()
                ->has(User::factory())
                ->has(Event::factory())
                ->create();
    $user = $role->users[0];
    $event = $role->events[0];

    actingAs($user)
        ->get("/event/$event->id")
        ->assertSeeLivewire('event-registration')
        ->assertStatus(200);
});

it('can link to first part directly', function () {
    $role = Role::factory()
                ->has(User::factory())
                ->has(Event::factory())
                ->create();
    $user = $role->users[0];
    $event = $role->events[0];
    $user->events()->attach($event);

    actingAs($user)
        ->get(route('event.show', $event).'?part=one')
        ->assertStatus(200)
        ->assertSee(__('registration.about-yeo'));
});

it('can link to second part directly', function () {
    $role = Role::factory()
                ->has(User::factory())
                ->has(Event::factory())
                ->create();
    $event = $role->events[0];
    $user = $role->users[0];
    $user->events()->attach($event);

    actingAs($user)
        ->get(route('event.show', $event).'?part=two')
        ->assertStatus(200)
        ->assertSeeText([
            __('registration.picture'),
            __('registration.motivation'),
            __('registration.passport-copy'),
            __('registration.appf-copy'),
            __('registration.insurance-policy'),
            __('registration.residence-permit'),
            __('registration.school-certificate'),
        ]);
});

it('defaults to part one if no part defined', function () {
    $role = Role::factory()
                ->has(User::factory())
                ->has(Event::factory())
                ->create();
    $user = $role->users[0];
    $event = $role->events[0];
    $user->events()->attach($event);

    actingAs($user)
        ->get(route('event.show', $event))
        ->assertStatus(200)
        ->assertSee(__('registration.about-yeo'));
});

it('defaults to part one if unknown part defined', function () {
    $role = Role::factory()
                ->has(User::factory())
                ->has(Event::factory())
                ->create();
    $user = $role->users[0];
    $event = $role->events[0];
    $user->events()->attach($event);

    actingAs($user)
        ->get(route('event.show', $event).'?part=nonexistent')
        ->assertStatus(200)
        ->assertSee(__('registration.about-yeo'));
});
