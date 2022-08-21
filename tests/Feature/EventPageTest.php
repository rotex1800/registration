<?php

use App\Models\Event;
use App\Models\User;
use function Pest\Laravel\actingAs;


it('shows main navigation', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    actingAs($user)
        ->get("/event/$event->id")
        ->assertSeeLivewire('main-navigation')
        ->assertStatus(200);
});

it('is not accessible when logged out', function () {
    $event = Event::factory()->create();
    $this->get("/event/$event->id")
        ->assertRedirect('/login');
});

it('shows event details component', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    actingAs($user)
        ->get("/event/$event->id")
        ->assertSeeLivewire('event-details')
        ->assertStatus(200);
});
