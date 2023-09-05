<?php

namespace Tests\Feature\Livewire;

use App\Models\Event;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\View\ViewException;
use Livewire\Livewire;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertEquals;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->payer = createUserWithRole('inbound');
    $this->event = Event::factory()->create();
});

it('can render', function () {
    $payment = Payment::factory(['amount' => 123])->make();
    $this->payer->payments()->save($payment);
    $this->event->payments()->save($payment);

    Livewire::test('add-payment', [
        'event' => $this->event,
        'payer' => $this->payer,
    ])
        ->assertStatus(200)
        ->assertSee([
            __('Summe'),
            123,
        ]);
});

it('requires event parameter', function () {
    Livewire::test('add-payment', [
        'payer' => $this->payer,
    ]);
})->throws(ViewException::class);

it('requires payer parameter', function () {
    Livewire::test('add-payment', [
        'event' => $this->event,
    ]);
})->throws(ViewException::class);

it('shows sum of all payments by payer for event', function () {
    $payments = Payment::factory(3, [
        'event_id' => $this->event->id,
        'user_id' => $this->payer->id,
    ])->create();
    $sum = $payments->sum('amount');

    Livewire::test('add-payment', [
        'event' => $this->event,
        'payer' => $this->payer,
    ])
        ->assertStatus(200)
        ->assertSee("Summe: $sum");
});

it('contains text input', function () {
    Livewire::test('add-payment', [
        'event' => $this->event,
        'payer' => $this->payer,
    ])
        ->assertStatus(200)
        ->assertSeeHtml(['input', 'type="text"', 'placeholder="Betrag"']);
});

it('has amount property wired', function () {
    Livewire::test('add-payment', [
        'event' => $this->event,
        'payer' => $this->payer,
    ])
        ->assertStatus(200)
        ->assertPropertyWired('amount');
});

it('has method for adding payment wired', function () {
    Livewire::test('add-payment', [
        'event' => $this->event,
        'payer' => $this->payer,
    ])
        ->assertStatus(200)
        ->assertMethodWired('addPayment');
});

it('adds payment for actor with correct role', function () {
    $actor = createUserWithRole('rotex');
    Livewire::actingAs($actor);
    Livewire::test('add-payment', [
        'payer' => $this->payer,
        'event' => $this->event,
    ])
        ->set('amount', 123)
        ->call('addPayment');

    assertDatabaseHas('payments', [
        'amount' => 123,
    ]);
});

it('does not add payment for actor with incorrect role', function () {
    Livewire::actingAs($this->payer);
    Livewire::test('add-payment', [
        'payer' => $this->payer,
        'event' => $this->event,
    ])
        ->set('amount', 123)
        ->call('addPayment');
    assertDatabaseCount('payments', 0);
});

it('clears input after adding payment', function () {
    $actor = createUserWithRole('rotex');
    Livewire::actingAs($actor);
    $actual = Livewire::test('add-payment', [
        'payer' => $this->payer,
        'event' => $this->event,
    ])
        ->set('amount', 123)
        ->call('addPayment')
        ->get('amount');

    assertEquals(null, $actual);
});

it('allows payment string to contain comma', function () {
    $actor = createUserWithRole('rotex');
    Livewire::actingAs($actor);
    Livewire::test('add-payment', [
        'payer' => $this->payer,
        'event' => $this->event,
    ])
        ->set('amount', '1,23')
        ->assertHasNoErrors()
        ->call('addPayment')
        ->assertHasNoErrors();
    assertDatabaseHas('payments', [
        'amount' => 1.23,
    ]);
});

it('allows exactly one decimal marker in payment amount', function () {
    $actor = createUserWithRole('rotex');
    Livewire::actingAs($actor);
    Livewire::test('add-payment', [
        'payer' => $this->payer,
        'event' => $this->event,
    ])
        ->assertStatus(200)
        ->assertHasNoErrors()
        ->set('amount', 'Hallo')
        ->assertHasErrors()
        ->set('amount', '32,1,2')
        ->assertHasErrors('amount')
        ->assertSee([
            __('validation.numeric', ['attribute' => __('validation.attributes.amount')]),
        ])
        ->set('amount', '12,0')
        ->assertHasNoErrors()
        ->set('amount', '32.1.2')
        ->assertHasErrors('amount');
});
