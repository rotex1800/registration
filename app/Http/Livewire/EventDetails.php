<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Policies\EventPolicy;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EventDetails extends Component
{
    public Event $event;

    public function render()
    {
        return view('livewire.event-details');
    }

    public function hasUserRegistered(): bool
    {
        $user = Auth::user();

        return $user->hasRegisteredFor($this->event);
    }

    public function register(): void
    {
        $user = Auth::user();
        $user->events()->attach($this->event);
        $user->save();
    }

    public function unregister(): void
    {
        $user = Auth::user();
        $user->events()->detach($this->event);
        $user->save();
    }

    public function canEdit()
    {
        $user = Auth::user();
        $policy = new EventPolicy();

        return $policy->canEditEvent($user)->allowed();
    }
}
