<?php

use App\Models\Event;
use App\Models\Role;
use App\Models\User;
use App\Policies\EventPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->cut = new EventPolicy();
});

it('denies a user with "rotex" role to edit an event', function () {
    $user = createUserWithRole('rotex');
    expect($this->cut->canEditEvent($user))->toBeAllowed();
});

it('denies a user with "other" role to edit an event', function () {
    $user = createUserWithRole('other');
    expect($this->cut->canEditEvent($user))->toBeDenied();
});

it('denies editing event for a null user', function () {
    expect($this->cut->canEditEvent(null))->toBeDenied();
});

it('allows user with matching role to see event', function () {
    $role = Role::factory()->create();
    $user = User::factory()->create();
    $user->roles()->attach($role);
    $user->save();

    $event = Event::factory()->create();
    $event->roles()->attach($role);
    $event->save();

    expect($this->cut->show($user, $event))->toBeAllowed();
});

it('denies user without matching role to see event', function () {
    $user = createUserWithRole('some');
    $event = Event::factory()
                  ->has(Role::factory()->state(['name' => 'other']))
                  ->create();
    expect($this->cut->show($user, $event))->toBeDenied();
});

it('denies guest to see event', function () {
    $event = Event::factory()->create();
    expect($this->cut->show(null, $event))->toBeDenied();
});


it('allows rotex to see event registrations', function () {
    $user = User::factory()
                ->has(Role::factory()->state(['name' => 'rotex']))
                ->create();
    expect($this->cut->seeRegistrations($user))->toBeAllowed();
});

it('denies other user to see event registration', function () {
    $user = User::factory()
                ->has(Role::factory()->state(['name' => 'other']))
                ->create();

    expect($this->cut->seeRegistrations($user))->toBeDenied();
});

it('denies null user to see event registration', function () {
    expect($this->cut->seeRegistrations(null))->toBeDenied();
});
