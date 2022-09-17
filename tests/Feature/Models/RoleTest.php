<?php

use App\Models\Event;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('belongs to many users', function () {
    $role = Role::factory()->create();
    $relation = $role->users();
    expect($relation)
        ->toBeInstanceOf(BelongsToMany::class)
        ->and($relation->getRelated())
        ->toBeInstanceOf(User::class);
});

it('belongs to many events', function () {
    $role = Role::factory()->create();
    $relation = $role->events();
    expect($relation)
        ->toBeInstanceOf(BelongsToMany::class)
        ->and($relation->getRelated())
        ->toBeInstanceOf(Event::class);
});
