<?php

use App\Models\Event;
use App\Models\Role;
use App\Models\User;
use App\Policies\RolePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->cut = new RolePolicy();
});

it('allows deletion of standalone role', function () {
    $role = Role::factory()->create();
    expect($this->cut->isDeletionAllowed($role))->toBeAllowed();
});

it('denies deletion of role associated with users', function () {
    $role = Role::factory()
        ->has(User::factory())
        ->create();

    expect($this->cut->isDeletionAllowed($role))->toBeDenied();
});

it('denies deletion of role associated with events', function () {
    $role = Role::factory()
        ->has(Event::factory())
        ->create();

    expect($this->cut->isDeletionAllowed($role))->toBeDenied();
});
