<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertTrue;

it('shows main navigation', function () {
    $user = User::factory()->create();
    actingAs($user)
        ->get('/home')
        ->assertSeeLivewire('main-navigation')
    ;
});

it('shows events the user attends', function () {
    $user = User::factory()
                ->has(Event::factory()->count(2))
                ->create()
    ;

    actingAs($user)
        ->get('/home')
        ->assertSee('Meine Events')
        ->assertSeeLivewire('event-summary')
    ;
});
