<?php

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('can download excel file', function () {
    $user = createUserWithRole('rotex');
    $event = Event::factory()->create();
    $attendee = User::factory()->make();
    $event->attendees()->save($attendee);

    Excel::fake();
    actingAs($user)
        ->get('/registrations/1/download')
        ->assertStatus(200);

    Excel::assertDownloaded("$event->name.xlsx");
});

it('can not download as guest', function () {
    $this->get('/registrations/1/download')
        ->assertRedirect(route('login'));
});

it('can not download as participant', function () {
    $event = Event::factory()->create();
    $user = createUserWithRole('participant');
    actingAs($user)
        ->get('/registrations/1/download')
        ->assertStatus(403);
});

it('does not fail exporting null values', function () {
    $user = createUserWithRole('rotex');
    $event = Event::factory()->create();
    $attendee = User::factory()->create();
    $event->attendees()->save($attendee);

    actingAs($user)->get(route('registrations.download', $event))
        ->assertStatus(200);
});
