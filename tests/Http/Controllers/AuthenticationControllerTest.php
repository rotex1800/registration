<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Fortify;

uses(RefreshDatabase::class);

it('redirects to home for succeeding authentication', function () {
    $user = User::factory()->create();
    $this->post('/login', [
        'password' => 'password',
        'password_confirmation' => 'password',
        Fortify::username() => $user->email,
    ])->assertRedirect(route('home'));
});

it('redirects to login for failing authentication', function () {
    $user = User::factory()->create();
    $this->post('/login', [
        'password' => 'supersecret',
        'password_confirmation' => 'supersecret',
        Fortify::username() => $user->email,
    ])->assertRedirect(route('login'));
});
