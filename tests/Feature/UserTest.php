<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

it('has events relation', function () {
    expect((new User())->events())
        ->toBeInstanceOf(BelongsToMany::class)
    ;
});

it('belongs to roles', function () {
    $user = User::factory()->create();
    expect($user->roles())
        ->toBeInstanceOf(BelongsToMany::class)
    ;
});