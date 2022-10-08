<?php

namespace Tests\Actions\Fortify;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates the new user with the participant rule', function () {
    $action = new CreateNewUser();
    $attributes = User::factory()->definition();
    $attributes['password'] = 'password';
    $attributes['password_confirmation'] = 'password';

    expect($action->create($attributes))
        ->toBeInstanceOf(User::class)
        ->hasRole('participant')->toBeTrue();
});
