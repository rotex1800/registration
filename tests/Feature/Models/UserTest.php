<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

it('has events relation', function () {
    expect((new User())->events())
        ->toBeInstanceOf(BelongsToMany::class);
});

it('can determine if user has registered for event', function () {
    $event = \App\Models\Event::factory()->create();
    $user = User::factory()->create();
    assertFalse($user->hasRegisteredFor($event));
    $user->events()->save($event);
    assertTrue($user->hasRegisteredFor($event));
});

it('belongs to roles', function () {
    $user = User::factory()->create();
    expect($user->roles())
        ->toBeInstanceOf(BelongsToMany::class);
});

it('returns registered-for events', function () {
    $user = User::factory()->create();
    $expected = \App\Models\Event::factory()->count(2)->create();
    $user->events()->saveMany($expected);

    $actual = $user->participatesIn();
    assertEquals(0, $actual->diff($expected)->count());
    assertEquals(0, $expected->diff($actual)->count());
});

it('returns events the user can still register for', function () {
    $role = Role::factory()->create();
    $user = User::factory()->create();
    $user->roles()->attach($role);

    $attends = \App\Models\Event::factory()->create();
    $attends->roles()->attach($role);
    $user->events()->attach($attends);

    $canAttend = \App\Models\Event::factory()->create();
    $canAttend->roles()->attach($role);

    assertFalse($user->canRegisterFor()->contains($attends));
    assertTrue($user->participatesIn()->contains($attends));

});


it('can check if it has a role', function() {
    $user = createUserWithRole('role');
    expect($user->hasRole('role'))
    ->toBeTrue()
    ->and($user->hasRole('other'))
    ->toBeFalse();
});
