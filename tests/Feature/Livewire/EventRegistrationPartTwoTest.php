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

    // Assert

    $this->component->assertStatus(200)
        // See headlines from part two
                    ->assertSeeTextInOrder($this->headlinesPartTwo);
});

it('hides part two when calling method to show part one', function () {
    // Act
    $this->component->call('showPartOne');

    // Assert
    $this->component->assertStatus(200)
        // See headlines from part one
                    ->assertSeeTextInOrder($this->headlinesPartOne);
});
