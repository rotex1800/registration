<?php

namespace App\Http\Livewire;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentState;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class DocumentUpload extends Component
{
    use WithFileUploads, HasCommentSection;

    /**
     * @var string
     */
    public $displayName;

    /**
     * @var string
     */
    public $category;

    /**
     * @var UploadedFile
     */
    public $file;

    public bool $disabled = false;

    public string $message = '';

    public User $user;

    /**
     * @var string[]
     */
    private $defaultRules = [
        'file' => 'required|mimes:pdf|file|max:10240',
    ];

    /**
     * @var string[]
     */
    private $pictureRules = [
        'file' => 'required|image|file|max:10240',
    ];

    /**
     * @return array<string>
     */
    public function messages(): array
    {
        return [
            'file.required' => strval(__('registration.upload-no-file-selected')),
        ];
    }

    public function mount(): void
    {
        $user = Auth::user();
        if ($user == null) {
            abort(401);
        }

        $this->user = $user;
        $this->message = $this->getStringForDocumentState();
        $this->document = $user->documentBy(DocumentCategory::read($this->category));
        $this->comments = $this->document->comments;
    }

    private function getStringForDocumentState(): string
    {
        $document = $this->user->documentBy(DocumentCategory::read($this->category));

        if ($document == null || $document->path == null) {
            return strval(__('document.state_not_uploaded'));
        }
        $state = $document->state;
        $string = '';
        switch ($state) {
            case DocumentState::Submitted:
                $string = __('document.state_submitted');
                break;
            case DocumentState::Approved:
                $string = __('document.state_approved');
                break;
            case DocumentState::Declined:
                $string = __('document.state_declined');
                break;
        }

        return strval($string);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.document-upload', [
            'displayName' => $this->displayName,
        ]);
    }

    public function save(): void
    {
        $this->validate();

        $clientOriginalName = $this->file->getClientOriginalName();
        $extension = $this->file->getClientOriginalExtension();
        $path = 'documents/'.$this->user->uuid;
        Storage::disk()->putFileAs($path, $this->file, $this->category.'.'.$extension);

        $dbDoc = $this->user->documentBy(DocumentCategory::read($this->category));
        $filePath = $path.'/'.$this->category.'.'.$extension;

        $dbDoc->name = $clientOriginalName;
        $dbDoc->state = DocumentState::Submitted;
        $dbDoc->path = $filePath;
        $dbDoc->type = Document::TYPE_DIGITAL;
        $dbDoc->save();

        $this->message = strval(__('registration.upload-success'));
    }

    /**
     * @return string[]
     */
    protected function getRules(): array
    {
        if ($this->category == DocumentCategory::Picture->value) {
            return $this->pictureRules;
        } else {
            return $this->defaultRules;
        }
    }
}
