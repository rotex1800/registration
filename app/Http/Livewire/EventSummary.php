<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Illuminate\View\View;
use Livewire\Component;

class EventSummary extends Component
{
    public Event $event;

    public function render(): View
    {
        return view('livewire.event-summary');
    }
}
