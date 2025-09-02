<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasComments
{
    public function createComment(string $withContent, mixed $authorId): Comment|bool
    {
        $comment = new Comment([
            'content' => $withContent,
            'author_id' => $authorId,
        ]);

        return $this->comments()->save($comment);
    }

    /**
     * @return MorphMany<Comment>
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
