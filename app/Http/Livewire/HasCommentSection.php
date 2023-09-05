<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Document;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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

        /** @var int $id */
        $id = Auth::user()?->getAuthIdentifier();
        $authorId = intval($id);
        $result = $this->document?->createComment($this->comment, $authorId);
        if ($result) {
            $this->document?->refresh();
            $this->comments = $this->document?->comments;
        }
        $this->comment = '';
    }

    public function updatedComment(string $value): void
    {
        $this->comment = trim($value);
    }
}
