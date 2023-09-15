<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

uses(RefreshDatabase::class);

it('verifies logged out users', closure: function () {
    // Arrange
    $user = User::factory()->unverified()->create();
    $url = URL::temporarySignedRoute('verification.verify',
        Carbon::now()->addMinutes(60),
        [
            'id' => $user->id,
            'hash' => sha1($user->email),
        ]);

    // Act
    $this->get($url)
        ->assertRedirect(route('home'));

    // Assert
    $user->refresh();
    assertTrue($user->hasVerifiedEmail());
});

it('does not verify user for bad hash', function () {
    // Arrange
    $user = User::factory()->unverified()->create();
    $url = URL::temporarySignedRoute('verification.verify',
        Carbon::now()->addMinutes(60),
        [
            'id' => $user->id,
            'hash' => 'badhash',
        ]);

    // Act
    $this->get($url)
        ->assertRedirect(route('home'));

    // Assert
    $user->refresh();
    assertFalse($user->hasVerifiedEmail());
});

it('sends verification email', function () {
    // Arrange
    Notification::fake();
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
        ->post(route('verification.send'))
        ->assertRedirect(route('verification.notice'));

    Notification::assertSentTo($user, VerifyEmail::class);
});

it('requires authentication to request verification email', function () {
    $this->post(route('verification.send'))
        ->assertRedirect(route('login'));
});

it('shows verification hint for unverified user', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
        ->get(route('home'))
        ->assertRedirect(route('verification.notice'));
});

it('requires authentication to see verification hint', function () {
    $this->get(route('verification.notice'))
        ->assertRedirect(route('login'));
});
