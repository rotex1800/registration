<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
