<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\User;
use App\Policies\EventPolicy;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Redirector;

class EventRegistration extends Component
{
    public Event $event;
    public array $districts;
    public User $user;

    protected array $rules = [
        'user.first_name' => 'nullable',
        'user.family_name' => 'nullable',
        'user.gender' => 'nullable|in:female,male,diverse,na',
        'user.birthday' => 'nullable|date',
        'user.mobile_phone' => 'nullable',
        'user.health_issues' => 'nullable',
    ];


    public function mount()
    {
        $this->districts = json_decode(Storage::disk('local')->get('districts.json'));
        $this->user = Auth::user();
    }

    public function render(): View
    {
        return view('livewire.event-registration');
    }

    public function hasUserRegistered(): bool
    {
        return $this->user->hasRegisteredFor($this->event);
    }

    public function register(): void
    {
        $this->user->events()->attach($this->event);
        $this->user->save();
    }

    public function unregister(): void
    {
        $this->user->events()->detach($this->event);
        $this->user->save();
    }

    public function canEdit(): bool
    {
        $policy = new EventPolicy();
        return $policy->canEditEvent($this->user)->allowed();
    }

    public function edit(): Redirector|RedirectResponse
    {
        return redirect()->route('event.edit', [
            'event' => $this->event->id
        ]);
    }

    public function saveUser()
    {
        $this->user->save();
    }
}
