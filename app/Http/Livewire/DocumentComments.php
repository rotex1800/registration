<?php

namespace App\Http\Livewire;

use App\Models\Document;
use Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DocumentComments extends Component
{
    public string $comment = '';

    public Document $document;

    public function render(): View|Factory
    {
        return view('livewire.document-comments');
    }

    public function saveComment(): void
    {
        $author = Auth::user();
        if ($author == null) {
            return;
        }

        if (blank($this->comment)) {
            return;
        }

        $this->document->createComment($this->comment, $author->getAuthIdentifier());
    }

    public function updatedComment(string $value): void
    {
        $this->comment = trim($value);
    }
}
