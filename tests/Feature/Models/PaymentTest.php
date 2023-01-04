<?php

use App\Models\Payment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has correct migration', function () {
    expect(Payment::factory()->create())
        ->not->toBeNull();
});

it('has amount', function () {
    expect(Payment::factory()->make())
        ->amount->toBeNumeric();
});

it('belongs to event', function () {
    expect(Payment::factory()->make())
        ->event()->toBeInstanceOf(BelongsTo::class);
});

it('belongs to user', function () {
    expect(Payment::factory()->make())
        ->user()->toBeInstanceOf(BelongsTo::class);
});
