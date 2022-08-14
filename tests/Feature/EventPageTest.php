<?php

use App\Models\Event;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('is not accessible when logged out', function () {
    $event = Event::factory()->create();
    $this->get("/event/$event->id")
        ->assertRedirect('/login');
});


it('shows main navigation', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    actingAs($user)
        ->get("/event/$event->id")
        ->assertSeeLivewire('main-navigation')
        ->assertStatus(200);
});

it('shows event information', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    actingAs($user)
        ->get("/event/$event->id")
        ->assertSee($event->name)
        ->assertSee($event->start->isoFormat('d. MMMM Y'))
        ->assertSee($event->end->isoFormat('d. MMMM Y'));
});
