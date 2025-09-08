<?php

namespace App\Livewire;

use App\Models\DocumentCategory;
use App\Models\DocumentState;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

use function get_class;
use function get_class as get_class1;
use function get_class as get_class2;
use function get_class as get_class3;
use function get_class as get_class4;

class DocumentsRater extends Component
{
    use HasCommentSection;

    public User $user;

    /**
     * @var DocumentCategory
     */
    public $category;

    public function mount(): void
    {

        $this->commentable = $this->user->documentBy($this->category);
        $this->comments = $this->commentable->comments;
    }

    public function render(): Application|Factory|View
    {
        return view('livewire.documents-rater', [
            'category' => $this->category,
            'comments' => $this->comments,
        ]);
    }

    public function download(): ?StreamedResponse
    {
        if ($this->commentable != null && get_class4($this->commentable) === 'App\Models\Document' && $this->commentable->path != null) {
            $name = Str::snake($this->user->file_path_name.' '.$this->category->displayName());

            return Storage::disk()->download($this->commentable->path, $name);
        }

        return null;
    }

    public function state(): string
    {
        if ($this->commentable != null && get_class3($this->commentable) === 'App\Models\Document') {
            return match ($this->commentable->state) {
                DocumentState::Approved => '✅',
                DocumentState::Submitted => '⬆️',
                DocumentState::Declined => '⛔️',
                default => '🤷‍',
            };
        } else {
            return '🤷‍';
        }
    }

    public function approve(): void
    {
        if ($this->commentable != null && get_class2($this->commentable) === 'App\Models\Document') {
            $this->commentable->state = DocumentState::Approved;
            $this->commentable->save();
        }
    }

    public function decline(): void
    {
        if ($this->commentable != null && get_class1($this->commentable) === 'App\Models\Document') {
            $this->commentable->state = DocumentState::Declined;
            $this->commentable->save();
        }
    }

    public function isDocumentPresent(): bool
    {
        return $this->commentable != null && get_class($this->commentable) === 'App\Models\Document' && $this->commentable->path != null;
    }
}
