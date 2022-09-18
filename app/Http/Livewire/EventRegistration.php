<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Policies\EventPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class EventRegistration extends Component
{
    public Event $event;
    public array $districts;

    public function mount()
    {
        $this->districts = json_decode(Storage::disk('local')->get('districts.json'));
    }

    public function render()
    {
        return view('livewire.event-registration');
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

    public function edit() {
        return redirect()->route('event.edit', [
            'event' => $this->event->id
        ]);
    }
}
