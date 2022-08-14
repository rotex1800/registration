<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\EventSummary;
use App\Models\Event;
use Livewire\Livewire;

test('event summary can render', function () {
    $event = Event::factory()->create();
    $component = Livewire::test(EventSummary::class, [
        'event' => $event
    ]);
    $component
        ->assertStatus(200)
        ->assertSee($event->name)
        ->assertSee($event->start->isoFormat('d. MMMM Y'))
        ->assertSee($event->end->isoFormat('d. MMMM Y'))
        ->assertMethodWired('show')
        ->assertSee("Details");
});

it('redirects to events detail page', function () {
    $event = Event::factory()->create();
    $component = Livewire::test(EventSummary::class, [
        'event' => $event
    ]);

    $component
        ->call('show')
        ->assertRedirect("/event/$event->id");
});
