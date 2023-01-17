<?php

use App\Models\Event;
use App\Models\Payment;
use App\Models\User;
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

test('user can sum all payments for a event', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();
    $paymentOne = Payment::factory()->make();
    $paymentTwo = Payment::factory()->make();
    $event->payments()->saveMany([$paymentOne, $paymentTwo]);
    $user->payments()->saveMany([$paymentOne, $paymentTwo]);

    expect($user->sumPaidFor($event))
        ->toBe($paymentOne->amount + $paymentTwo->amount);
});
