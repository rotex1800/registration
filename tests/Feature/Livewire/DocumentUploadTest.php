<?php

namespace Tests\Feature\Livewire;

use App\Livewire\DocumentUpload;
use App\Models\Comment;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentState;
use App\Models\Passport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Livewire\WithFileUploads;
use Storage;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->category = DocumentCategory::SchoolCertificate;
    $this->user = User::factory()->create();

    $this->document = Document::factory([
        'category' => $this->category->value,
        'state' => DocumentState::Submitted->value,
    ])->make();

    $this->user->documents()->save($this->document);

    actingAs($this->user);
    $this->component = Livewire::test('documents-rater', [
        'user' => $this->user,
        'category' => $this->category,
    ]);
});

it('uses file upload trait', function () {
    $result = in_array(WithFileUploads::class, class_uses_recursive(DocumentUpload::class));
    expect($result)->toBeTrue();
});

it('shows name passed to component', function () {
    $comp = Livewire::test('document-upload', [
        'category' => 'passport',
        'displayName' => 'Test File',
    ]);

    $comp->assertStatus(200)
        ->assertSee('Test File')
        ->set('displayName', 'Other File')
        ->assertStatus(200)
        ->assertSee('Other File');
});

it('has save method wired to form', function () {
    $comp = Livewire::test('document-upload', ['category' => 'passport']);
    $comp->assertMethodWiredToForm('save');
});

it('has file wired', function () {
    $passport = Passport::factory()->make();
    $this->user->passport()->save($passport);
    Livewire::test('document-upload', [
        'category' => 'passport',
        'disabled' => false,
    ])->assertPropertyWired('file');
});

it('stores uploaded file', function () {
    $user = $this->user;
    Storage::fake();
    $file = UploadedFile::fake()->create('foo.pdf', 1024, 'application/pdf');

    Livewire::test('document-upload', ['category' => 'passport'])
        ->set('file', $file)
        ->call('save');
    Storage::disk()->assertExists('documents/'.$user->uuid.'/passport.pdf');
});

it('requires pdf files', function () {
    $user = $this->user;
    Storage::fake();
    $file = UploadedFile::fake()->image('avatar.png');

    Livewire::test('document-upload', ['category' => 'passport'])
        ->set('file', $file)
        ->call('save');
    Storage::disk()->assertMissing('documents/'.$user->uuid.'/passport.png');
});

it('allows image upload for the picture', function () {
    $user = $this->user;
    Storage::fake();
    $file = UploadedFile::fake()->image('avatar.png');

    Livewire::test('document-upload', ['category' => 'picture'])
        ->set('file', $file)
        ->call('save');
    Storage::disk()->assertExists('documents/'.$user->uuid.'/picture.png');
});

test('uploading file creates entry in document table', function () {
    Storage::fake('documents');
    $file = UploadedFile::fake()->create('foo.pdf', 1024, 'application/pdf');

    Livewire::test('document-upload', ['category' => 'passport'])
        ->set('file', $file)
        ->call('save');

    $userPassport = $this->user->documentBy(DocumentCategory::PassportCopy);
    expect($userPassport)
        ->not->toBeNull()
        ->name->toBe('foo.pdf')
        ->type->toBe(Document::TYPE_DIGITAL)
        ->state->toBe(DocumentState::Submitted)
        ->path->toBe('documents/'.$this->user->uuid.'/passport.pdf');
});

it('has consts for document types', function () {
    expect(Document::TYPE_DIGITAL)->toBe(0)
        ->and(Document::TYPE_ANALOG)->toBe(1);
});

it('it shows approved status', function () {
    $document = Document::factory()
        ->approved()
        ->withCategory(DocumentCategory::PassportCopy)
        ->make();

    $this->user->documents()->save($document);

    Livewire::test('document-upload', [
        'category' => DocumentCategory::PassportCopy->value,
    ])
        ->assertStatus(200)
        ->assertSee(__('✅'));
});

it('it shows submitted status', function () {
    $document = Document::factory()->submitted()->withCategory(DocumentCategory::PassportCopy)->make();
    $this->user->documents()->save($document);

    Livewire::test('document-upload', [
        'category' => DocumentCategory::PassportCopy->value,
    ])
        ->assertStatus(200)
        ->assertSee(__('⬆️'));
});

it('it shows declined status', function () {
    $document = Document::factory()->declined()->withCategory(DocumentCategory::PassportCopy)->make();
    $this->user->documents()->save($document);

    Livewire::test('document-upload', [
        'category' => DocumentCategory::PassportCopy->value,
    ])
        ->assertStatus(200)
        ->assertSee(__('⛔️'));
});

it('shows not uploaded status', function () {
    Livewire::test('document-upload', [
        'category' => DocumentCategory::PassportCopy->value,
    ])
        ->assertStatus(200)
        ->assertSee(__('❓'));
});

it('shows file input for complete form', function () {
    Livewire::test('document-upload', [
        'category' => DocumentCategory::PassportCopy->value,
    ])->assertStatus(200)
        ->assertSet('message', __('document.state_not_uploaded'))
        ->assertSee(__('document.state_not_uploaded'))
        ->assertSeeHtml('<input');
});

it('it does not cause error for a second upload of the same document', function () {
    $fileOne = UploadedFile::fake()->create('one.pdf', mimeType: 'application/pdf');
    $fileTwo = UploadedFile::fake()->create('two.pdf', mimeType: 'application/pdf');

    Livewire::test('document-upload', [
        'category' => DocumentCategory::InsurancePolice->value,
    ])
        ->assertStatus(200)
        ->set('file', $fileOne)
        ->call('save')
        ->set('file', $fileTwo)
        ->call('save');

    $doc = $this->user->documentBy(DocumentCategory::InsurancePolice);
    expect($doc->name)->toBe('two.pdf');
});

it('shows success message after upload', function () {
    $file = UploadedFile::fake()->create('one.pdf', mimeType: 'application/pdf');

    Livewire::test('document-upload', [
        'category' => DocumentCategory::InsurancePolice->value,
    ])
        ->assertStatus(200)
        ->set('file', $file)
        ->call('save')
        ->assertSee(__('registration.upload-success'));
});

it('shows error message if upload is attempted before file selection', function () {
    Livewire::test('document-upload', [
        'category' => DocumentCategory::Motivation->value,
    ])
        ->assertStatus(200)
        ->call('save')
        ->assertHasErrors([
            'file' => 'required',
        ]);
});

// SECTION START: Comments
it('has save comment method wired', function () {
    Livewire::test('document-upload', [
        'category' => $this->category->value,
    ])->assertStatus(200)
        ->assertMethodWired('saveComment');
});

it('saves a comment', function () {
    $author = User::factory()->create();
    $component = Livewire::test('document-upload', [
        'category' => $this->category->value,
    ]);
    $component
        ->assertStatus(200)
        ->set('comment', 'I am a comment!')
        ->call('saveComment');

    $this->document->refresh();
    expect($this->document->comments)
        ->toHaveCount(1);

    expect($this->document->comments[0])
        ->author_id->toBe($this->user->id)
        ->content->toBe('I am a comment!');
});

it('clears current comment when saving a new comment', function () {
    $author = User::factory()->create();
    $component = Livewire::test('document-upload', [
        'category' => $this->category->value,
    ]);
    $component
        ->assertStatus(200)
        ->set('comment', 'I am a comment!')
        ->call('saveComment');

    expect($component->get('comment'))
        ->toBe('');
});

it('does not save blank comments', function () {
    $author = User::factory()->create();
    actingAs($author);
    Livewire::test('document-upload', [
        'category' => DocumentCategory::Motivation->value,
    ])
        ->assertStatus(200)
        ->set('comment', '    ')
        ->call('saveComment');

    $this->document->refresh();
    expect($this->document->comments)
        ->toHaveCount(0);
});

it('does not save empty comment', function () {
    $author = User::factory()->create();
    actingAs($author);
    Livewire::test('document-upload', [
        'category' => DocumentCategory::Motivation->value,
    ])
        ->assertStatus(200)
        ->set('comment', '')
        ->call('saveComment');

    $this->document->refresh();
    expect($this->document->comments)
        ->toHaveCount(0);
});

it('trims comments', function () {
    $author = User::factory()->create();
    Livewire::test('document-upload', [
        'category' => $this->category->value,
    ])
        ->assertStatus(200)
        ->set('comment', 'I am a comment!            ')
        ->call('saveComment');

    $this->document->refresh();
    expect($this->document->comments)
        ->toHaveCount(1);

    expect($this->document->comments[0])
        ->author_id->toBe($this->user->id)
        ->content->toBe('I am a comment!');
});

it('shows comments', function () {
    // Arrange
    $comments = Comment::factory()->count(3)->make();
    $this->document->comments()->saveMany($comments);

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
    $component = Livewire::test('document-upload', [
        'user' => $attendee,
        'category' => $this->category->value,
    ]);

    // Act
    actingAs($attendee);
    $component->assertStatus(200)
        ->set('comment', 'Comment by attendee')
        ->call('saveComment');

    // Assert
    expect($this->document->comments[0])
        ->author_id->toBe($attendee->id);
});
