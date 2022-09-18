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

it('has section for information about the person', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event
    ]);
    $component->assertSeeTextInOrder([
        __('registration.about-you'),
        __('registration.first-name'),
        __('registration.familiy-name'),
        __('registration.birthday'),
        __('registration.gender.gender'),
        __('registration.mobilephone'),
        __('registration.health-issues'),
    ]);
});

it('has section for information about passport', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event
    ]);

    $component->assertSeeTextInOrder([
        __('registration.passport'),
        __('registration.nationality'),
        __('registration.passport-number'),
        __('registration.passport-issue-date'),
        __('registration.passport-expiration-date'),
    ]);
});

it('has section for information about rotary', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event
    ]);

    $component->assertSeeTextInOrder([
        __('registration.about-rotary'),
        __('registration.rotary.host-club'),
        __('registration.rotary.host-district'),
        __('registration.rotary.sponsor-club'),
        __('registration.rotary.sponsor-district')
    ]);
});

it('has section for information about counselor', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event
    ]);

    $component->assertSeeTextInOrder([
        __('registration.about-counselor'),
        __('registration.counselor.name'),
        __('registration.counselor.telephone'),
        __('registration.counselor.email'),
    ]);
});

it('has section for information about yeo', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event
    ]);

    $component->assertSeeTextInOrder([
        __('registration.about-yeo'),
        __('registration.yeo.name'),
        __('registration.yeo.telephone'),
        __('registration.yeo.email'),
    ]);
});

it('has section for family in home country', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event
    ]);

    $component->assertSeeTextInOrder([
        __('registration.about-bio-family'),
        __('registration.bio-family.parent-one'),
        __('registration.bio-family.parent-two'),
        __('registration.bio-family.email'),
        __('registration.bio-family.telephone'),
    ]);
});

it('has section for first host family', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event
    ]);
    $component->assertSeeTextInOrder([
        __('registration.about-host-family-one'),
        __('registration.host-family.name'),
        __('registration.host-family.email'),
        __('registration.host-family.address'),
    ]);
});

it('has section for second host family', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event
    ]);
    $component->assertSeeTextInOrder([
        __('registration.about-host-family-two'),
        __('registration.host-family.name'),
        __('registration.host-family.email'),
        __('registration.host-family.address'),
    ]);
});

it('has section for third host family', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event
    ]);
    $component->assertSeeTextInOrder([
        __('registration.about-host-family-three'),
        __('registration.host-family.name'),
        __('registration.host-family.email'),
        __('registration.host-family.address'),
    ]);
});

it('has text area for comments', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event
    ]);

    $component->assertSeeTextInOrder([
        __('registration.comment')
    ]);
});
