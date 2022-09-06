<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

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
