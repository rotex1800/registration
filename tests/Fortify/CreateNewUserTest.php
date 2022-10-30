<?php

namespace Tests\Actions\Fortify;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

it('creates the new user with the participant rule', function () {
    $action = new CreateNewUser();
    $attributes = User::factory()->definition();
    $attributes['email'] = 'test@rotex1800.de';
    $attributes['password'] = 'password';
    $attributes['password_confirmation'] = 'password';

    expect($action->create($attributes))
        ->toBeInstanceOf(User::class)
        ->hasRole('participant')->toBeTrue();
});

it('assigns a uuid to each new user', function () {
    $action = new CreateNewUser();
    $attributes = User::factory()->definition();
    $attributes['email'] = 'test@rotex1800.de';
    $attributes['password'] = 'password';
    $attributes['password_confirmation'] = 'password';

    expect($action->create($attributes))
        ->uuid->not->toBeNull();
});

it('does not allow example.net emails', function () {
    $action = new CreateNewUser();
    $attributes = User::factory()->definition();
    $attributes['email'] = 'test@example.net';
    $attributes['password'] = 'password';
    $attributes['password_confirmation'] = 'password';

    $action->create($attributes);
})->throws(ValidationException::class);

it('does not allow example.org emails', function () {
    $action = new CreateNewUser();
    $attributes = User::factory()->definition();
    $attributes['email'] = 'test@example.org';
    $attributes['password'] = 'password';
    $attributes['password_confirmation'] = 'password';

    $action->create($attributes);
})->throws(ValidationException::class);
