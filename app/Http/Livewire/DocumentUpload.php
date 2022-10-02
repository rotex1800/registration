<?php

namespace App\Http\Livewire;

use App\Models\Document;
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
    public User $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.document-upload', [
            'displayName' => $this->displayName
        ]);
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
