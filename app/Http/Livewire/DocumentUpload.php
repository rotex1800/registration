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
    use WithFileUploads;

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

    /**
     * @var User
     */
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
    }

    /**
     * @return string
     */
    private function getStringForDocumentState(): string
    {
        $document = $this->user->documentBy(DocumentCategory::read($this->category));
        if ($document == null) {
            return strval(__('document.state_not_uploaded'));
        }
        $state = $document->state;

        $string = match ($state) {
            DocumentState::Submitted => __('document.state_submitted'),
            DocumentState::Approved => __('document.state_approved'),
            DocumentState::Declined => __('document.state_declined'),
            default => __('document.state_not_uploaded')
        };

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
        if ($dbDoc == null) {
            $document = Document::factory()->state([
                'name' => $clientOriginalName,
                'path' => $path.'/'.$this->category.'.'.$extension,
                'state' => DocumentState::Submitted,
            ])->digital()
                                ->withCategory(DocumentCategory::read($this->category))
                                ->make();

            $this->user->documents()->save($document);
        } else {
            $dbDoc->name = $clientOriginalName;
            $dbDoc->state = DocumentState::Submitted;
            $dbDoc->save();
        }
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
