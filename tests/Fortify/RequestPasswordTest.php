<?php

use function Pest\Laravel\get;

it('shows main navigation', function () {
    get(route('password.request'))
        ->assertStatus(200)
        ->assertSeeLivewire('main-navigation');
});

it('shows reset password link', function () {
    get(route('password.request'))
        ->assertSeeInOrder([
            __('signup.forgot-password'),
            __('signup.forgot-password-explanation'),
            __('signup.email'),
            __('signup.forgot-password-cta'),
        ]);
});

it('is accessible without authentication', function () {
    get(route('password.request'))
        ->assertStatus(200);
});
