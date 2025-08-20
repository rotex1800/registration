<?php

namespace Tests\Actions\Fortify;

use App\Actions\Fortify\UpdateUserPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

it('requires current password input to match current password', function () {
    // Arrange
    $user = User::factory()->withPassword('12345678')->make();
    $action = new UpdateUserPassword;
    $input = [
        'current_password' => 'abcdefgh',
        'password' => 'abcdefgh',
        'password_confirmation' => 'abcdefgh',
    ];

    // Act
    $action->update($user, $input);

    // Assert
})->throws(ValidationException::class);

it('updates password if current matches', function () {
    // Arrange
    $user = User::factory()->withPassword('12345678')->make();
    $action = new UpdateUserPassword;
    $input = [
        'current_password' => '12345678',
        'password' => 'abcdefgh',
        'password_confirmation' => 'abcdefgh',
    ];

    // Act
    $action->update($user, $input);
    $user->refresh();

    // Assert
    expect(Hash::check('abcdefgh', $user->password))
        ->toBeTrue();
});
