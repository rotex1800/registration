<?php

namespace App\Livewire;

use App\Models\AdditionalInfo;
use App\Models\User;
use App\Policies\NotePolicy;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddNote extends Component
{
    public User $attendee;

    public ?string $note = null;

    public function render(): Factory|View|Application
    {
        $this->note = $this->attendee->additionalInfo?->note;

        return view('livewire.add-note')->with([
            'note' => $this->note,
        ]);
    }

    public function updatedNote(string $note): void
    {
        $allowedToCreateNote = (new NotePolicy())->createNote(Auth::user())->allowed();
        if ($allowedToCreateNote) {
            $info = $this->attendee->additionalInfo;
            if ($info == null) {
                $info = new AdditionalInfo();
            }
            $info->note = $note;
            $this->attendee->additionalInfo()->save($info);
        }
    }
}
