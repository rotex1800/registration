<?php

use App\Http\Middleware\ApplicationAvailability;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\WithoutMiddleware;

it('is accessible', function () {
    $this->get('/')
         ->assertStatus(200);
});

it('contains main navigation', function () {
    $this->get('/')
         ->assertSeeLivewire('main-navigation');
});

it('shows explanation text', function () {
    $this->get('/')
         ->assertSeeTextInOrder([
             __('root.welcome'),
             __('root.introduction'),
         ]);
});

it('shows register link', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->assertSeeIn('#register', __('signup.register'))
                ->clickLink(__('signup.register'))
                ->assertUrlIs(route('register'));
    });
})->skip('Skipping test until middleware is figured out in Dusk tests');

it('shows login link', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->assertSeeIn('#login', __('signup.login'))
                ->clickLink(__('signup.login'))
                ->assertUrlIs(route('login'));
    });
})->skip('Skipping test until middleware is figured out in Dusk tests');
