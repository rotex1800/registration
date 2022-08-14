<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;

class EventSummary extends Component
{
    public Event $event;

    public function render(): View
    {
        return view('livewire.event-summary');
    }

    public function show(): Redirector|RedirectResponse
    {
        return redirect()->route('event.show', [
            'id' => $this->event->id
        ]);
    }
}
