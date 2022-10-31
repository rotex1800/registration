<?php

namespace App\Http\Livewire;

trait HasCommentSection
{
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
