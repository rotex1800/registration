<?php

namespace Tests\Actions\Fortify;

use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->action = new ResetUserPassword();
});

it('requires a password to be present', function () {
    $input = array();
    $this->action->reset($this->user, $input);
})->throws(ValidationException::class);

it('requires the new password to be a string', function () {
    $input = [
        'password' => 1234567890,
        'password_confirmation' => 1234567890,
    ];
    $this->action->reset($this->user, $input);
})->throws(ValidationException::class);

it('requires the user to be confirmed to reset the password', function () {
    $input = [
        'password' => 1234567890,
        'password_confirmation' => 1234567890,
    ];
    $this->user->email_verified_at = null;
    $this->action->reset($this->user, $input);
})->throws(ValidationException::class);

it('requires the password to be at least 8 characters long', function () {
    $input = [
        'password' => '1234567',
        'password_confirmation' => '1234567',
    ];
    $this->action->reset($this->user, $input);
})->throws(ValidationException::class);

it('succeeds with a password of length 8', function () {
    $input = [
        'password' => '12345678',
        'password_confirmation' => '12345678'
    ];
    $this->action->reset($this->user, $input);
    expect(true)->toBeTrue();
});

it('sets the hashed password on the given user', function () {
    $input = [
        'password' => 'abcdefgh',
        'password_confirmation' => 'abcdefgh',
    ];
    $this->action->reset($this->user, $input);
    $this->user->refresh();

    expect(Hash::check($input['password'], $this->user->password))
        ->toBeTrue();
});
