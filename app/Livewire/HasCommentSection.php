<?php

namespace App\Livewire;

use App\Models\AdditionalInfo;
use App\Models\Comment;
use App\Models\Document;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait HasCommentSection
{
    public string $comment = '';

    /**
     * @var Collection<int, Comment>|null
     */
    public ?Collection $comments = null;

    /**
     * @var AdditionalInfo|Document|null
     */
    public $commentable = null;

    public function saveComment(): void
    {
        if (blank($this->comment)) {
            return;
        }

        /** @var int $id */
        $id = Auth::user()?->getAuthIdentifier();
        $authorId = intval($id);
        $result = $this->commentable?->createComment($this->comment, $authorId);
        if ($result) {
            $this->commentable?->refresh();
            $this->comments = $this->commentable?->comments;
        }
        $this->comment = '';
    }

    public function updatedComment(string $value): void
    {
        $this->comment = trim($value);
    }
}
