<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\EventDetails;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

uses(RefreshDatabase::class);

it('shows event information', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    actingAs($user);
    $component = Livewire::test(EventDetails::class, [
        'event' => $event,
    ]);

    $component
        ->assertSee($event->name)
        ->assertSee($event->start->isoFormat('d. MMMM Y'))
        ->assertSee($event->end->isoFormat('d. MMMM Y'));
});

it('contains button to register if not yet registered', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    actingAs($user);
    $component = Livewire::test(EventDetails::class, [
        'event' => $event,
    ]);
    $component
        ->assertMethodWired('register')
        ->assertSee('Anmelden')
        ->assertDontSee('Abmelden');

    assertFalse(
        $user->hasRegisteredFor($event)
    );

    $component
        ->call('register');

    assertTrue(
        $user->hasRegisteredFor($event)
    );
});

it('contains button to de-register if already registered', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    $user->events()->attach($event);
    actingAs($user);
    $component = Livewire::test(EventDetails::class, [
        'event' => $event,
    ]);
    $component
        ->assertMethodWired('unregister')
        ->assertSee('Abmelden')
        ->assertDontSee('Anmelden');

    $component->call('unregister');

    assertFalse($user->hasRegisteredFor($event));
});

it('shows edit button for user with correct role', function () {
    $user = createUserWithRole('rotex');
    $event = Event::factory()->create();
    $user->events()->attach($event);
    actingAs($user);
    $component = Livewire::test(EventDetails::class, [
        'event' => $event,
    ]);
    actingAs($user);
    $component
        ->assertSee('Bearbeiten');
});

it('does not show edit button for user with some role', function () {
    $user = createUserWithRole('role');
    $event = Event::factory()->create();
    actingAs($user);
    $component = Livewire::test(EventDetails::class, [
        'event' => $event,
    ]);
    $component
        ->assertDontSee('Bearbeiten')
        ->assertMethodNotWired('edit');
});
