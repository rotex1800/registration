<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\assertDatabaseCount;

uses(RefreshDatabase::class);

it('creates a new event', function () {
    // Arrange

    // Act
    $this->artisan('registration:create')
         ->expectsQuestion('What is the name of the event?', 'EuropaTour 2024')
        ->expectsQuestion("When does it start?", '2024-03-25')
        ->expectsQuestion('When does it end?', '2024-04-14')
        ->assertOk();

    // Assert
    assertDatabaseCount('events', 1);
    $actual = \App\Models\Event::all()->first();
    expect($actual)
        ->name->toBe('EuropaTour 2024')
        ->start->format('Y-m-d')->toBe('2024-03-25')
        ->end->format('Y-m-d')->toBe('2024-04-14')
    ;
});
