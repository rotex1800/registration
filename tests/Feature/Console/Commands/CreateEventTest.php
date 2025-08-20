<?php

use App\Models\Role;
use App\Policies\EventPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseCount;

uses(RefreshDatabase::class);

it('creates a new event with multiple roles', function (array|string $eventRoles) {
    // Arrange
    Role::factory()->participant()->create();
    Role::factory()->rotex()->create();

    // Act
    $this->artisan('registration:create')
        ->expectsQuestion('What is the name of the event?', 'EuropaTour 2024')
        ->expectsQuestion('When does it start?', '2024-03-25')
        ->expectsQuestion('When does it end?', '2024-04-14')
        ->expectsChoice(
            'Who is the target audience of the event?',
            $eventRoles,
            ['participant', 'rotex']
        )
        ->assertOk();

    // Assert
    assertDatabaseCount('events', 1);
    $actual = App\Models\Event::all()->first();

    if (is_array($eventRoles)) {
        foreach ($eventRoles as $eventRole) {
            assertEventCanBeShownToRole($actual, $eventRole);
        }
    } else {
        assertEventCanBeShownToRole($actual, $eventRoles);
    }
    expect($actual)
        ->name->toBe('EuropaTour 2024')
        ->start->format('Y-m-d')->toBe('2024-03-25')
        ->end->format('Y-m-d')->toBe('2024-04-14');
})->with([
    'participant',
    [['rotex', 'participant']],
]);

function assertEventCanBeShownToRole(App\Models\Event $event, string $role): void
{
    $eventPolicy = new EventPolicy;
    expect($eventPolicy)
        ->show(createUserWithRole($role), $event)->toBeAllowed();
}
