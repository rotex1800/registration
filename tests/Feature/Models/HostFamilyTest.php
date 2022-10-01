<?php

use App\Models\HostFamily;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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

it('has address', function () {
    expect($this->family->address)
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

it('has order', function () {
    $family = HostFamily::factory()->create();
    expect($family->order)
        ->toBeInt();
});

it('has scope for host family order', function () {
    expect(HostFamily::order(1))
        ->toBeInstanceOf(Builder::class);
});

test('factory provides empty defaults', function () {
    $family = HostFamily::factory()->empty()->make();
    expect($family->name)
        ->toBe('')
        ->and($family->email)->toBe('')
        ->and($family->address)->toBe('')
        ->and($family->phone)->toBe('')
        ->and($family->order)->toBe(0);
});

test('factory provides family with given order', function () {
    $family = HostFamily::factory()->nth(3)->make();
    expect($family->order)->toBe(3);
});

it('can combine empty and nth states', function () {
    $family = HostFamily::factory()->empty()->nth(2)->make();
    expect($family->name)
        ->toBe('')
        ->and($family->email)->toBe('')
        ->and($family->phone)->toBe('')
        ->and($family->order)->toBe(2);
});
