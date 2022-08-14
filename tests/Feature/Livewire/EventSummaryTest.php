<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\EventSummary;
use App\Models\Event;
use Livewire\Livewire;
use Tests\TestCase;

class EventSummaryTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $event = Event::factory()->create();
        $component = Livewire::test(EventSummary::class, [
            'event' => $event
        ]);
        $component
            ->assertStatus(200)
            ->assertSee($event->name)
            ->assertSee($event->start->isoFormat('d. MMMM Y'))
            ->assertSee($event->end->isoFormat('d. MMMM Y'))
        ;
    }
}
