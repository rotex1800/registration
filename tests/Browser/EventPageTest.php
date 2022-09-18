<?php

use App\Models\Event;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

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
