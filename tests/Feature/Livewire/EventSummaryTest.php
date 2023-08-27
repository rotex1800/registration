<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\EventSummary;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->event = Event::factory()->create();
    $this->component = Livewire::test(EventSummary::class, [
        'event' => $this->event,
    ]);
});

test('event summary can render', function () {
    $event = $this->event;
    $this->component
        ->assertStatus(200)
        ->assertSee($event->name)
        ->assertSee($event->start->translatedFormat('d. F Y'))
        ->assertSee($event->end->translatedFormat('d. F Y'))
        ->assertMethodWired('show')
        ->assertSee('Details');
});

it('shows correct dates', function () {
    $event = Event::factory()->state([
        'start' => Carbon::parse('2023-03-22 00:00:00'),
        'end' => Carbon::parse('2023-04-08 00:00:00'),
    ])->make();
    Livewire::test('event-summary', [
        'event' => $event,
    ])
        ->assertStatus(200)
        ->assertSee('22. März 2023')
        ->assertSee('08. April 2023');
});

it('redirects to events detail page', function () {
    $event = $this->event;
    $this->component
        ->call('show')
        ->assertRedirect("/event/$event->id");
});
