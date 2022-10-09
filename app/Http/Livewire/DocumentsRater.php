<?php

namespace App\Http\Livewire;

use App\Models\Document;
use App\Models\DocumentState;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class DocumentsRater extends Component
{
    public User $user;

    public $category;

    public ?Document $document = null;

    public function mount()
    {
        $this->document = $this->user->documentBy($this->category);
    }

    public function render()
    {
        return view('livewire.documents-rater', [
            'category' => $this->category,
        ]);
    }

    public function download()
    {
        if ($this->document != null && $this->document->path != null) {
            $name = Str::snake($this->user->full_name.' '.$this->category->displayName());

            return Storage::disk()->download($this->document->path, $name);
        }

        return null;
    }

    public function state()
    {
        if ($this->document == null) {
            return '🤷‍';
        }

        return match ($this->document->state) {
            DocumentState::Approved => '✅',
            DocumentState::Submitted => '⬆️',
            DocumentState::Declined => '⛔️',
            default => '🤷‍',
        };
    }

    public function approve()
    {
        if ($this->document != null) {
            $this->document->state = DocumentState::Approved;
            $this->document?->save();
        }
    }

    public function decline()
    {
        if ($this->document != null) {
            $this->document->state = DocumentState::Declined;
            $this->document->save();
        }
    }
}
