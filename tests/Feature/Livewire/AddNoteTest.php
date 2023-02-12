<?php

namespace Tests\Feature\Livewire;

use App\Models\AdditionalInfo;
use App\Models\ClothesSize;
use App\Models\Event;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\View\ViewException;
use Livewire\Livewire;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEquals;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->attendee = createUserWithRole('inbound');
});

it('can render', function () {
    $additionalInfo = AdditionalInfo::factory()->make();
    $this->attendee->additionalInfo()->save($additionalInfo);

    Livewire::test('add-note', [
        'attendee' => $this->attendee,
    ])
            ->assertStatus(200)
            ->assertSee([
                __('Notiz'),
                $additionalInfo->note,
            ]);
});

it('requires notee parameter', function () {
    Livewire::test('add-note');
})->throws(ViewException::class);

it('contains text area', function () {
    Livewire::test('add-note', [
        'attendee' => $this->attendee
    ])
            ->assertStatus(200)
            ->assertSeeHtml(['textarea']);
});

it('has note property wired', function () {
    Livewire::test('add-note', [
        'attendee' => $this->attendee
    ])
            ->assertStatus(200)
            ->assertPropertyWired('note');
});

it('adds note for actor with correct role', function () {
    $actor = createUserWithRole('rotex');
    $info = AdditionalInfo::factory()->state([
        'tshirt_size' => ClothesSize::XL,
        'allergies' => 'Spinach',
        'diet' => 'Only spinach',
        'note' => 'Tough life',
    ])->make();
    $this->attendee->additionalInfo()->save($info);

    Livewire::actingAs($actor);
    Livewire::test('add-note', [
        'attendee' => $this->attendee,
    ])->set('note', 'Test Note');

    assertDatabaseHas('additional_infos', [
        'allergies' => 'Spinach',
        'diet' => 'Only spinach',
        'note' => 'Test Note',
    ]);
});

it('does not edit note for actor with incorrect role', function () {
    Livewire::actingAs($this->attendee);
    Livewire::test('add-note', [
        'attendee' => $this->attendee,
    ])
            ->set('note', 'New Test Note');
    $this->attendee->refresh();
    assertNotEquals('New Test Note', $this->attendee->additionalInfo?->note);
});
