<?php

namespace App\Http\Livewire;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentState;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class DocumentUpload extends Component
{
    use WithFileUploads;

    public $displayName;

    public $category;

    public $file;

    public $disabled = false;

    public User $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        $state = $this->getStringForDocumentState();

        return view('livewire.document-upload', [
            'displayName' => $this->displayName,
            'state' => $state,
        ]);
    }

    /**
     * @return string
     */
    private function getStringForDocumentState(): string
    {
        $infoRelation = $this->user->relationFor(DocumentCategory::tryFrom($this->category));

        if ($infoRelation == null
            || $infoRelation->first() == null
            || ! $infoRelation->first()->isComplete()
        ) {
            $this->disabled = true;

            return __('document.state_form_incomplete');
        }

        $document = $infoRelation->first()->document;
        if ($document == null) {
            return __('document.state_not_uploaded');
        }
        $state = $document->state;

        return match (DocumentState::tryFrom($state)) {
            DocumentState::Submitted => __('document.state_submitted'),
            DocumentState::Approved => __('document.state_approved'),
            default => __('document.state_not_uploaded')
        };
    }

    public function save()
    {
        $this->validate([
            'file' => 'max:5120',
        ]);

        $clientOriginalName = $this->file->getClientOriginalName();
        $extension = $this->file->getClientOriginalExtension();
        $path = 'documents/'.$this->user->uuid;
        Storage::disk()->putFileAs($path, $this->file, $this->category.'.'.$extension);

        $document = Document::factory()->state([
            'name' => $clientOriginalName,
            'path' => $path.'/'.$this->category.'.'.$extension,
        ])->digital()->make();

        $this->user->documents()->save($document);

        $document->save();
    }
}
