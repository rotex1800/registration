<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Dusk\Browser;
use function Pest\Laravel\actingAs;

it('shows the login form for non authenticated users', function () {
    $response = $this->get('/login');
    $response->assertStatus(200)
             ->assertSeeLivewire('login-form')
             ->assertSeeLivewire('main-navigation');
});

it('redircts to home for authenticated users', function () {
    $user = User::factory()->create();
    actingAs($user)
        ->get('/login')
        ->assertRedirect('/home')
        ->assertStatus(302);
});

it('naviagtes to password reset', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit(route('login'))
                ->assertSeeLink(__('signup.forgot-password'))
                ->clickLink(__('signup.forgot-password'))
                ->assertUrlIs(route('password.request'));
    });
});
