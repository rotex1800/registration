<?php

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('event has attendees relation', function () {
    expect((new Event())->attendees())
        ->toBeInstanceOf(BelongsToMany::class);
});

test('event can retrieve attendees', function () {
    $event = Event::factory()
                  ->has(User::factory()->count(3), 'attendees')
                  ->create();

    expect($event->attendees()->get())
        ->toHaveCount(3)
        ->each->toBeInstanceOf(User::class);
});

it('returns attendees sorted by first name', function () {
    // Arrange
    $first = User::factory()->state(['first_name' => 'C'])->make();
    $second = User::factory()->state(['first_name' => 'B'])->make();
    $third = User::factory()->state(['first_name' => 'A'])->make();
    $event = Event::factory()->create();
    $event->attendees()->saveMany([$first, $second, $third]);

    // Act & Assert
    $sortedAttendees = $event->attendeesSortedByFirstName();
    $firstNames = $sortedAttendees->map(fn ($e) => $e->first_name);
    expect($firstNames)
        ->toArray()->toEqual(['A', 'B', 'C']);
});

test('event has name', function () {
    $event = Event::factory()->state([
        'name' => 'Deutschland Tour',
    ])->create();
    expect($event->name)->toBe('Deutschland Tour');

    $defaultEvent = Event::factory()->default()->create();
    expect($defaultEvent->name)->toBe('Unnamed Event');
});

test('event start time', function () {
    $event = Event::factory()->state([
        'start' => Carbon::parse('2022-07-23T08:12:30', 'Europe/Berlin'),
    ])->create();
    expect($event->start->year)->toBe(2022)
                               ->and($event->start->month)->toBe(7)
                               ->and($event->start->day)->toBe(23)
                               ->and($event->start->hour)->toBe(8)
                               ->and($event->start->minute)->toBe(12)
                               ->and($event->start->second)->toBe(30);
});

test('event end time', function () {
    $event = Event::factory()->state([
        'end' => Carbon::parse('2020-05-21T18:02:45', 'Europe/Madrid'),
    ])->create();
    expect($event->end->year)->toBe(2020)
                             ->and($event->end->month)->toBe(5)
                             ->and($event->end->day)->toBe(21)
                             ->and($event->end->hour)->toBe(18)
                             ->and($event->end->minute)->toBe(2)
                             ->and($event->end->second)->toBe(45);
});

it('has role relation', function () {
    $event = Event::factory()->create();
    expect($event->roles())
        ->toBeInstanceOf(BelongsToMany::class);
});

it('has short name', function () {
    $event = Event::factory()->state([
        'name' => 'Awesome Event',
        'start' => Carbon::parse('2022-11-27'),
    ])->make();

    expect($event->short_name)
        ->toBe('AE-2022');
});
