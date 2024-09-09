<?php

namespace App\Livewire;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class EventSummary extends Component
{
    public Event $event;

    public function render(): View
    {
        return view('livewire.event-summary');
    }

    public function show(): RedirectResponse|Redirector
    {
        return redirect()->route('event.show', [
            'event' => $this->event->id,
        ]);
    }
}
