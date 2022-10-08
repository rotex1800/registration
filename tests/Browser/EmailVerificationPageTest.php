<?php

use App\Models\User;
use function Pest\Laravel\actingAs;

it('redirects back to home for a verfied email', function () {
    actingAs(User::factory()->create())
        ->get(route('verification.notice'))
        ->assertRedirect('/home');
});

it('shows a button to request re-sending the verification email', function () {
    actingAs(User::factory()->unverified()->create())
        ->get(route('verification.notice'))
        ->assertStatus(200)
        ->assertSee(__('signup.verify-email'))
        ->assertSee(__('signup.verify-email-explanation'))
        ->assertSee(__('signup.resend-verification-email'));
});
