<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Document;
use Illuminate\Support\Collection;

trait HasCommentSection
{
    public string $comment = '';

    /**
     * @var Collection<Comment>|null
     */
    public ?Collection $comments = null;

    public ?Document $document = null;

    public function saveComment(): void
    {
        if (blank($this->comment)) {
            return;
        }
        $this->document?->createComment($this->comment, $this->user->getAuthIdentifier());
    }

    public function updatedComment(string $value): void
    {
        $this->comment = trim($value);
    }
}