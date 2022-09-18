<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\EventRegistration;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->event = Event::factory()->create();
});

it('shows event information', function () {
    $user = User::factory()->create();
    actingAs($user);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $component
        ->assertSee($this->event->name)
        ->assertSee($this->event->start->isoFormat('d. MMMM Y'))
        ->assertSee($this->event->end->isoFormat('d. MMMM Y'));
});

it('contains button to register if not yet registered', function () {
    $user = User::factory()->create();
    actingAs($user);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component
        ->assertMethodWired('register')
        ->assertSee('Anmelden')
        ->assertDontSee('Abmelden');

    assertFalse(
        $user->hasRegisteredFor($this->event)
    );

    $component
        ->call('register');

    assertTrue(
        $user->hasRegisteredFor($this->event)
    );
});

it('contains button to de-register if already registered', function () {
    $user = User::factory()->create();
    $user->events()->attach($this->event);
    actingAs($user);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component
        ->assertMethodWired('unregister')
        ->assertSee('Abmelden')
        ->assertDontSee('Anmelden');

    $component->call('unregister');

    assertFalse($user->hasRegisteredFor($this->event));
});

it('shows edit button for user with correct role', function () {
    $user = createUserWithRole('rotex');
    $user->events()->attach($this->event);
    actingAs($user);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    actingAs($user);
    $component
        ->assertSee('Bearbeiten')
        ->assertMethodWired('edit');
});

test('edit method redirects to edit page', function () {
    $user = createUserWithRole('rotex');
    $user->events()->attach($this->event);
    actingAs($user);
    Livewire::test(EventRegistration::class, [
        'event' => $this->event
    ])
            ->call('edit')
            ->assertRedirect(route('event.edit', $this->event));

});

it('does not show edit button for user with some role', function () {
    $user = createUserWithRole('role');
    actingAs($user);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component
        ->assertDontSee('Bearbeiten')
        ->assertMethodNotWired('edit');
});
