<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Role;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('shows main navigation', function () {
    $user = User::factory()->create();
    actingAs($user)
        ->get('/home')
        ->assertSeeLivewire('main-navigation')
    ;
});

it('shows events the user attends', function () {
    $user = User::factory()
                ->has(Event::factory()->count(2))
        ->create();

    actingAs($user)
        ->get('/home')
        ->assertSee('Meine Events')
        ->assertSeeLivewire('event-summary');
});

it('does not show my events section if the user does not attend any events', function () {
    $user = User::factory()->create();
    actingAs($user)
        ->get("/home")
        ->assertDontSee('Meine Events')
        ->assertDontSeeLivewire('event-summary');
});

it('shows events the user can attend', function () {

    $role = Role::factory()->create();

    $user = User::factory()
        ->create();
    $user->roles()->attach($role);
    $user->save();

    $event = Event::factory()
        ->create();
    $event->roles()->attach($role);
    $event->save();

    actingAs($user)
        ->get('/home')
        ->assertSee('Weitere Events');
});


it('does not show events the user can not attend', function () {

    $user = User::factory()
        ->has(Role::factory())
        ->create();

    $event = Event::factory()
        ->has(Role::factory())
        ->create();

    actingAs($user)
        ->get('/home')
        ->assertDontSee('Weitere Events')
    ;
});
