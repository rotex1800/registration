<?php

namespace Tests\Feature\Livewire;

use App\Models\Comment;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentState;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->category = DocumentCategory::SchoolCertificate;
    $this->user = User::factory()->create();
    $this->commentable = Document::factory()
        ->submitted()
        ->withCategory($this->category)
        ->make();

    $this->user->documents()->save($this->commentable);
    actingAs($this->user);
    $this->component = Livewire::test('documents-rater', [
        'user' => $this->user,
        'category' => $this->category,
    ]);
});

it('can render', function () {
    $this->component->assertStatus(200);
});

it('contains description', function () {
    $this->component->assertStatus(200)
        ->assertSeeText($this->category->displayName());
});

it('has download method wired', function () {
    $this->component
        ->assertMethodWired('download');
});

it('has download method not wired for document with null path', function () {
    $category = DocumentCategory::SchoolCertificate;
    $user = User::factory()->create();
    $document = Document::factory()
        ->state([
            'path' => null,
        ])
        ->withCategory($category)
        ->make();

    $user->documents()->save($document);
    $component = Livewire::test('documents-rater', [
        'user' => $user,
        'category' => $category,
    ]);

    $component->assertStatus(200)
        ->assertMethodNotWired('download');
});

it('shows submitted state', function () {
    $category = DocumentCategory::Rules;
    $user = User::factory()->create();
    $document = Document::factory()
        ->submitted()
        ->withCategory($category)
        ->make();

    $user->documents()->save($document);
    Livewire::test('documents-rater', [
        'user' => $user,
        'category' => $category,
    ])
        ->assertSee('⬆️');
});

it('shows approved state', function () {
    $category = DocumentCategory::Rules;
    $user = User::factory()->create();
    $document = Document::factory()
        ->approved()
        ->withCategory($category)
        ->make();

    $user->documents()->save($document);
    Livewire::test('documents-rater', [
        'user' => $user,
        'category' => $category,
    ])
        ->assertSee('✅');
});

it('shows missing state', function () {
    $category = DocumentCategory::Rules;
    $user = User::factory()->create();
    Livewire::test('documents-rater', [
        'user' => $user,
        'category' => $category,
    ])
        ->assertSee('🤷‍');
});

it('shows declined state', function () {
    $category = DocumentCategory::Rules;
    $user = User::factory()->create();
    $document = Document::factory()
        ->declined()
        ->withCategory($category)
        ->make();

    $user->documents()->save($document);
    Livewire::test('documents-rater', [
        'user' => $user,
        'category' => $category,
    ])
        ->assertSee('⛔️');
});

it('has approve method wired', function () {
    $this->component
        ->assertSeeText('👍')
        ->assertMethodWired('approve');
});

it('has decline method wired', function () {
    $this->component
        ->assertSeeText('👎')
        ->assertMethodWired('decline');
});

it('can approve document', function () {
    $this->component
        ->call('approve');
    expect($this->commentable->refresh()->state)
        ->toBe(DocumentState::Approved);
});

it('can decline document', function () {
    $this->component
        ->call('decline');

    expect($this->commentable->refresh()->state)
        ->toBe(DocumentState::Declined);
});

it('does not crash approving for missing document', function () {
    $category = DocumentCategory::Rules;
    $user = User::factory()->create();
    Livewire::test('documents-rater', [
        'user' => $user,
        'category' => $category,
    ])
        ->call('approve')
        ->assertStatus(200);
});

it('does not crash declining for missing document', function () {
    $category = DocumentCategory::Rules;
    $user = User::factory()->create();
    Livewire::test('documents-rater', [
        'user' => $user,
        'category' => $category,
    ])
        ->call('decline')
        ->assertStatus(200);
});

it('downloads documents if a path is present', function (string $familyName) {
    // Arrange
    $user = User::factory()->create([
        'family_name' => $familyName,
    ]);

    $category = DocumentCategory::Rules;
    $fileName = $category->name.'.jpg';
    $fakeImage = UploadedFile::fake()->image($fileName);
    $path = 'documents/'.$this->user->uuid;

    Storage::fake();
    $actualPath = Storage::disk()->putFileAs($path, $fakeImage, $fileName);

    $document = Document::factory([
        'category' => $category,
        'path' => $actualPath,
    ])->make();
    $user->documents()->save($document);

    // Act & Assert
    $component = Livewire::test('documents-rater', [
        'user' => $user,
        'category' => $category,
    ])
        ->call('download')
        ->assertFileDownloaded();

    $response = data_get($component->effects, 'download');
    expect(Str::snake($response['name']))
        ->toContain(strtolower(Str::snake($user->file_path_name)))
        ->toContain(strtolower($category->displayName()))
        ->and($response)
        ->content->not->toBeEmpty()
        ->contentType->toBe('image/jpeg');
})->with(['Smith', "O' Connor"]);

it('does not download document without a path', function () {
    // Arrange
    $user = User::factory()->create();
    $category = DocumentCategory::Rules;

    // Act & Assert
    $component = Livewire::test('documents-rater', [
        'user' => $user,
        'category' => $category,
    ])->call('download')
        ->assertOk();

    expect(data_get($component->effects, 'download'))
        ->toBeNull();
});

// SECTION START: Comments
it('has save comment method wired', function () {
    $this->component
        ->assertStatus(200)
        ->assertMethodWired('saveComment');
});

it('saves a comment', function () {
    $author = User::factory()->create();
    $this->component
        ->assertStatus(200)
        ->set('comment', 'I am a comment!')
        ->call('saveComment');

    $this->commentable->refresh();
    expect($this->commentable->comments)
        ->toHaveCount(1);

    expect($this->commentable->comments[0])
        ->author_id->toBe($this->user->id)
        ->content->toBe('I am a comment!');
});

it('clears current comment when saving a new comment', function () {
    $this->component
        ->assertStatus(200)
        ->set('comment', 'I am a comment!')
        ->call('saveComment');

    expect($this->component->get('comment'))
        ->toBe('');
});

it('does not save blank comments', function () {
    $author = User::factory()->create();
    actingAs($author);
    $this->component
        ->assertStatus(200)
        ->set('comment', '    ')
        ->call('saveComment');

    $this->commentable->refresh();
    expect($this->commentable->comments)
        ->toHaveCount(0);
});

it('does not save empty comment', function () {
    $author = User::factory()->create();
    actingAs($author);
    $this->component
        ->assertStatus(200)
        ->set('comment', '')
        ->call('saveComment');

    $this->commentable->refresh();
    expect($this->commentable->comments)
        ->toHaveCount(0);
});

it('trims comments', function () {
    $author = User::factory()->create();
    $this->component
        ->assertStatus(200)
        ->set('comment', 'I am a comment!            ')
        ->call('saveComment');

    $this->commentable->refresh();
    expect($this->commentable->comments)
        ->toHaveCount(1);

    expect($this->commentable->comments[0])
        ->author_id->toBe($this->user->id)
        ->content->toBe('I am a comment!');
});

it('shows comments', function () {
    // Arrange
    $comments = Comment::factory()->count(3)->make();
    $this->commentable->comments()->saveMany($comments);

    // Act
    $component = Livewire::test('documents-rater', [
        'category' => $this->category,
        'user' => $this->user,
    ]);

    // Assert
    $component->assertStatus(200);
    foreach ($comments as $comment) {
        $component->assertSeeText($comment->content)
            ->assertSeeText($comment->author->full_name)
            ->assertSeeText($comment->created_at->translatedFormat('d. F Y H:i'));
    }
});

test('currently authenticated user is author of comment', function () {
    // Arrange
    $attendee = $this->user;
    $rotex = createUserWithRole('rotex');
    $component = Livewire::test('documents-rater', [
        'user' => $attendee,
        'category' => $this->category,
    ]);

    // Act
    actingAs($rotex);
    $component->assertStatus(200)
        ->set('comment', 'Comment by Rotex')
        ->call('saveComment');

    // Assert
    expect($this->commentable->comments[0])
        ->author_id->toBe($rotex->id);
});
