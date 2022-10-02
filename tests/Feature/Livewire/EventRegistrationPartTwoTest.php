<?php

use App\Http\Livewire\EventRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

// Arrange
beforeEach(function () {
    $this->headlinesPartOne = [
        __('registration.about-you'),
        __('registration.passport'),
        __('registration.about-rotary'),
        __('registration.about-counselor'),
        __('registration.about-yeo'),
        __('registration.about-bio-family'),
        __('registration.about-host-family-one'),
        __('registration.about-host-family-two'),
        __('registration.about-host-family-three'),
        __('registration.comment'),
    ];

    $this->headlinesPartTwo = [
        __('registration.passport-upload'),
    ];

    $this->event = \App\Models\Event::factory()->create();
    $this->user = createInboundRegisteredFor($this->event);
    actingAs($this->user);
    $this->component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
});

it('shows button for part one', function () {
    // Act & Assert
    $this->component->assertSeeTextInOrder([
        __('registration.part_one'),
        __('registration.about-you'),
    ]);
});

it('does not show button for unregistered user', function () {
    // Arrange
    $this->user->events()->detach($this->event->id);

    // Act & Assert
    $this->component->assertSeeTextInOrder([
        __('registration.part_one'),
        __('registration.about-you'),
    ]);
});

it('shows button for part two', function () {
    // Act & Assert
    $this->component->assertSeeTextInOrder([
        __('registration.part_one'),
        __('registration.part_two'),
    ]);
});

it('has methods for part one and two wired', function () {
    $this->component->assertMethodWired('showPartOne')
                    ->assertMethodWired('showPartTwo');
});

it('hides part one when calling method to show part two', function () {
    // Act
    $this->component->call('showPartTwo');

    // Assert it shows
    $this->component->assertStatus(200)
        // headlines from part two
                    ->assertSeeTextInOrder($this->headlinesPartTwo);
    // sets active part to two
    expect($this->component->activePart)
        ->toBe('two');
});

it('hides part two when calling method to show part one', function () {
    // Act & Assert it shows
    $this->component
        ->call('showPartOne')
        ->assertStatus(200)
        // headlines from part one
        ->assertSeeInOrder($this->headlinesPartOne);
    // sets active part to one
    expect($this->component->activePart)
        ->toBe('one');
});
