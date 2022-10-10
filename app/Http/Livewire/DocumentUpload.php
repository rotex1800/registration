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

    public $message = '';

    public User $user;

    private $defaultRules = [
        'file' => 'required|mimes:pdf|file|max:5120',
    ];

    private $pictureRules = [
        'file' => 'required|image|file|max:5120',
    ];

    public function messages()
    {
        return [
            'file.required' => __('registration.upload-no-file-selected'),
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->message = $this->getStringForDocumentState();
    }

    /**
     * @return string
     */
    private function getStringForDocumentState(): string
    {
        $document = $this->user->documentBy(DocumentCategory::tryFrom($this->category));
        if ($document == null) {
            return __('document.state_not_uploaded');
        }
        $state = $document->state;

        return match ($state) {
            DocumentState::Submitted => __('document.state_submitted'),
            DocumentState::Approved => __('document.state_approved'),
            DocumentState::Declined => __('document.state_declined'),
            default => __('document.state_not_uploaded')
        };
    }

    public function render()
    {
        return view('livewire.document-upload', [
            'displayName' => $this->displayName,
        ]);
    }

    public function save()
    {
        $this->validate();

        $clientOriginalName = $this->file->getClientOriginalName();
        $extension = $this->file->getClientOriginalExtension();
        $path = 'documents/'.$this->user->uuid;
        Storage::disk()->putFileAs($path, $this->file, $this->category.'.'.$extension);

        $dbDoc = $this->user->documentBy(DocumentCategory::tryFrom($this->category));
        if ($dbDoc == null) {
            $document = Document::factory()->state([
                'name' => $clientOriginalName,
                'path' => $path.'/'.$this->category.'.'.$extension,
                'state' => DocumentState::Submitted,
            ])->digital()
                                ->withCategory(DocumentCategory::tryFrom($this->category))
                                ->make();

            $this->user->documents()->save($document);
        } else {
            $dbDoc->name = $clientOriginalName;
            $dbDoc->state = DocumentState::Submitted;
            $dbDoc->save();
        }
        $this->message = __('registration.upload-success');
    }

    protected function getRules()
    {
        if ($this->category == DocumentCategory::Picture->value) {
            return $this->pictureRules;
        } else {
            return $this->defaultRules;
        }
    }
}
