<?php

use App\Models\Role;
use App\Models\User;
use App\Policies\EventPolicy;
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
         ->expectsQuestion('Who is the target audience of the event?', 'participant')
         ->assertOk();

    // Assert
    assertDatabaseCount('events', 1);
    $actual = App\Models\Event::all()->first();
    $participant = User::factory()
                       ->create();
    $participant->giveRole('participant');

    expect((new EventPolicy())->show($participant, $actual))
        ->toBeAllowed()
        ->and($actual)
        ->name->toBe('EuropaTour 2024')
        ->start->format('Y-m-d')->toBe('2024-03-25')
        ->end->format('Y-m-d')->toBe('2024-04-14');
});
