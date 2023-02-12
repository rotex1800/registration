<?php

namespace App\Http\Livewire;

use App\Models\AdditionalInfo;
use App\Models\User;
use App\Policies\NotePolicy;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddNote extends Component
{

    public User $attendee;

    public ?string $note = null;

    public function render()
    {
        $this->note = $this->attendee->additionalInfo?->note;
        return view('livewire.add-note');
    }

    public function updatedNote(string $note)
    {
        $allowedToCreateNote = (new NotePolicy())->createNote(Auth::user())->allowed();
        if ($allowedToCreateNote) {
            $this->attendee->additionalInfo->note = $note;
            $this->attendee->additionalInfo->save();
        }
    }

}
