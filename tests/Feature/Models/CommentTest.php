<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

it('has creation timestamp', function () {
    expect(Comment::factory()->create()->created_at)
    ->toBeInstanceOf(Carbon::class);
});

it('has updated timestamp', function () {
    expect(Comment::factory()->create()->updated_at)
    ->toBeInstanceOf(Carbon::class);
});

it('references an user as author', function () {
    $comment = Comment::factory()->create();
    expect($comment->author())
    ->toBeInstanceOf(BelongsTo::class)
    ->and($comment->author)
    ->toBeInstanceOf(User::class);
});

it('has content', function () {
    expect(Comment::factory()->create()->content)
    ->toBeString();
});
