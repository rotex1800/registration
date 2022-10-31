<?php

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('can render', function () {
    Livewire::test('document-comments')
            ->assertStatus(200);
});

it('has save comment method wired', function () {
    Livewire::test('document-comments')
            ->assertStatus(200)
            ->assertMethodWired('saveComment');
});

it('saves a comment', function () {
    $author = User::factory()->create();
    actingAs($author);
    $doc = Document::factory()->create();
    Livewire::test('document-comments', [
        'document' => $doc,
    ])
            ->assertStatus(200)
            ->set('comment', 'I am a comment!')
            ->call('saveComment');

    $doc->refresh();
    expect($doc->comments)
        ->toHaveCount(1);

    expect($doc->comments[0])
        ->author_id->toBe($author->id)
        ->content->toBe('I am a comment!');
});

it('does not save blank comments', function () {
    $author = User::factory()->create();
    actingAs($author);
    $doc = Document::factory()->create();
    Livewire::test('document-comments', [
        'document' => $doc,
    ])
            ->assertStatus(200)
            ->set('comment', '    ')
            ->call('saveComment');

    $doc->refresh();
    expect($doc->comments)
        ->toHaveCount(0);
});

it('does not save empty comment', function () {
    $author = User::factory()->create();
    actingAs($author);
    $doc = Document::factory()->create();
    Livewire::test('document-comments', [
        'document' => $doc,
    ])
            ->assertStatus(200)
            ->set('comment', '')
            ->call('saveComment');

    $doc->refresh();
    expect($doc->comments)
        ->toHaveCount(0);
});

it('trims comments', function () {
    $author = User::factory()->create();
    actingAs($author);
    $doc = Document::factory()->create();
    Livewire::test('document-comments', [
        'document' => $doc,
    ])
            ->assertStatus(200)
            ->set('comment', 'I am a comment!            ')
            ->call('saveComment');

    $doc->refresh();
    expect($doc->comments)
        ->toHaveCount(1);

    expect($doc->comments[0])
        ->author_id->toBe($author->id)
        ->content->toBe('I am a comment!');
});
