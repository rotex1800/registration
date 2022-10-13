<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('command works', function () {
    $user = User::factory()->create();
    $role = fake()->word;
    $this->artisan('registration:assign', [
        'role' => $role,
        'email' => $user->email,
    ])->assertExitCode(0);
    expect($user->hasRole($role))->toBeTrue();
});

it('fails if user can not be found', function () {
    $role = fake()->word;
    $email = fake()->email;
    $this->artisan('registration:assign', [
        'role' => $role,
        'email' => $email,
    ])->assertFailed();
});

it('it asks for role and user when called without arguments', function () {
    $user = User::factory()->create();
    $this->artisan('registration:assign')
         ->expectsQuestion("What's the name of the role?", 'rotex')
         ->expectsQuestion("What's the email of the user?", $user->email)
         ->expectsOutput("Assigning role 'rotex' to user with email '$user->email'")
         ->assertSuccessful();
    expect($user->hasRole('rotex'))->toBeTrue();
});

it('shows error message if the user can not be found', function () {
    $email = fake()->email;
    $this->artisan('registration:assign', [
        'email' => $email,
        'role' => fake()->word,
    ])->expectsOutput("There is no user with email '$email'")
         ->assertFailed();
});
