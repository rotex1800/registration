<?php

use App\Models\RegistrationComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('belongs to a user', function () {
    $comment = RegistrationComment::factory()->create();
    expect($comment->user())
        ->toBeInstanceOf(BelongsTo::class);

    $user = User::factory()->make();

    $comment->user()->associate($user);

    expect($comment->user)
        ->toBeInstanceOf(User::class)
        ->toBeSameEntityAs($user);
});

it('has a body', function () {
    $comment = RegistrationComment::factory()->create();
    expect($comment->body)
        ->toBeString();
});
