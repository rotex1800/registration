<?php

use App\Models\HostFamily;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->family = HostFamily::factory()->create();
});

it('has name', function () {
    expect($this->family->name)
        ->toBeString();
});

it('has email', function () {
    expect($this->family->email)
        ->toBeString();
});

it('has phone', function () {
    expect($this->family->phone)
        ->toBeString();
});

it('belongs to user', function () {
    expect($this->family->inbound())
        ->toBeInstanceOf(BelongsTo::class);
});

it('can retrieve user through relation', function () {
    $user = User::factory()
        ->has(HostFamily::factory())
        ->create();

    $family = $user->hostFamilies()->first();

    expect($family->inbound)
        ->not->toBeNull()
        ->toBeInstanceOf(User::class);
});
