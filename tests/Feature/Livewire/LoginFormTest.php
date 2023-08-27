<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\LoginForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('login form can render', function () {
    $component = Livewire::test(LoginForm::class);
    $component->assertStatus(200)
        ->assertPropertyWired('email')
        ->assertPropertyWired('password')
        ->assertPropertyWired('remember')
        ->assertMethodWiredToForm('login')
        ->assertSee('Passwort')
        ->assertSee('E-Mail')
        ->assertSee('Login');
});

it('logs in the user', function () {
    $user = User::factory()->create();
    $component = Livewire::test(LoginForm::class);
    $component->set('password', 'password')
        ->set('email', $user->email)
        ->call('login')
        ->assertRedirect('/home');
});

it('shows link to password reset', function () {
    Livewire::test('login-form')
        ->assertSeeText(__('signup.forgot-password'));
});

it('redirects to login route for failed authentication', function () {
    Livewire::test('login-form')
        ->assertStatus(200)
        ->set('password', 'super-secret')
        ->set('email', 'test@example.org')
        ->call('login')
        ->assertRedirect(route('login'));
});
