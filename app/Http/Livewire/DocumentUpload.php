<?php

namespace App\Http\Livewire;

use App\Models\Document;
use App\Models\DocumentCategory;
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
    public $enabled = true;
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
            'state' => $state
        ]);
    }

    /**
     * @return string
     */
    private function getStringForDocumentState(): string
    {
        if ($this->category == DocumentCategory::PassportCopy->rawValue()) {
            $passport = $this->user->passport;
            if ($passport == null || !$passport->isComplete()) {
                $this->enabled = false;
                return __('document.state_form_incomplete');
            }

            $document = $passport->document;
            if ($document == null) {
                return __('document.state_not_uploaded');
            }
            $state = $document->state;
            if ($state == Document::SUBMITTED) {
                return __('document.state_submitted');
            }
            if ($state == Document::APPROVED) {
                return __('document.state_approved');
            }
        }
        return __('document.state_not_uploaded');
    }

    public function save()
    {

        $this->validate([
            'file' => 'max:5120'
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
