<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\MainNavigation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;

uses(DatabaseMigrations::class);

it('shows the application name', function () {
    $applicationName = config('app.name');
    Livewire::test(MainNavigation::class)
            ->assertSee($applicationName);
});

it('shows the users name', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    Livewire::test(MainNavigation::class)
            ->assertSee($user->full_name);
});

it('handles logged out state', function () {
    Livewire::test(MainNavigation::class)
            ->assertDontSee('Logout')
            ->assertDontSee('Home')
            ->assertMethodNotWired('toHome')
            ->assertSee(__('signup.register'))
            ->assertSee(__('signup.login'))
            ->assertMethodWired('toLogin')
            ->assertMethodWired('toRegister')
            ->assertStatus(200);
});

it('shows logout button for logged in users', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    Livewire::test(MainNavigation::class)
            ->assertSee('Logout');
});

it('logs the user out when logout is clicked', function () {
    $user = User::factory()->create();
    Livewire::actingAs($user)
            ->test(MainNavigation::class)
            ->set('loggedIn', true)
            ->assertMethodWired('logout')
            ->call('logout')
            ->assertRedirect('/login');
});

it('can navigate back to home', function () {
    $user = User::factory()->create();
    Livewire::actingAs($user)
            ->test(MainNavigation::class)
            ->assertSee('Home')
            ->assertMethodWired('toHome')
            ->call('toHome')
            ->assertRedirect('/home');
});

it('can navigate to login form', function () {
    Livewire::test('main-navigation')
            ->call('toLogin')
            ->assertRedirect('/login');
});

it('can navigate to registration form', function () {
    Livewire::test('main-navigation')
            ->call('toRegister')
            ->assertRedirect('/register');
});
