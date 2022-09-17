<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\EventSummary;
use App\Models\Event;
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
        ->assertSee($event->start->isoFormat('d. MMMM Y'))
        ->assertSee($event->end->isoFormat('d. MMMM Y'))
        ->assertMethodWired('show')
        ->assertSee('Details');
});

it('redirects to events detail page', function () {
    $event = $this->event;
    $this->component
        ->call('show')
        ->assertRedirect("/event/$event->id");
});
