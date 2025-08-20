<?php

use App\Models\Document;
use App\Models\Role;
use App\Policies\CommentPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows participant user to comment on own document', function () {
    $policy = new CommentPolicy;
    $document = Document::factory()->create();
    $user = $document->owner;
    $user->roles()->delete();
    $user->roles()->attach(Role::factory()->participant()->create());
    $user->save();

    expect($policy->userCanCommentDocument($user, $document))
        ->toBeAllowed();
});

it('denies participant user to comment other document', function () {
    $policy = new CommentPolicy;
    $document = Document::factory()->create();
    $user = createUserWithRole('participant');

    expect($policy->userCanCommentDocument($user, $document))
        ->toBeDenied();
});

it('denies other user to comment', function () {
    $policy = new CommentPolicy;
    $document = Document::factory()->create();
    $user = createUserWithRole('other');

    expect($policy->userCanCommentDocument($user, $document))
        ->toBeDenied();
});

it('allows rotex user to comment on own document', function () {
    $policy = new CommentPolicy;
    $document = Document::factory()->create();
    $user = $document->owner;
    $user->roles()->delete();
    $user->roles()->attach(Role::factory()->rotex()->create());
    $user->save();

    expect($policy->userCanCommentDocument($user, $document))
        ->toBeAllowed();
});

it('allows rotex user to comment on other document', function () {
    $policy = new CommentPolicy;
    $document = Document::factory()->create();
    $user = createUserWithRole('rotex');

    expect($policy->userCanCommentDocument($user, $document))
        ->toBeAllowed();
});
