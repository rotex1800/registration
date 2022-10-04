<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\DocumentUpload;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Passport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire;
use Livewire\WithFileUploads;
use Storage;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    actingAs($this->user);
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
    $file = UploadedFile::fake()->image('avatar.png');

    Livewire::test('document-upload', ['category' => 'passport'])
            ->set('file', $file)
            ->call('save');
    Storage::disk()->assertExists('documents/'.$user->uuid.'/passport.png');
});

it('uploading file creates entry in document table', function () {
    Storage::fake('documents');
    $file = UploadedFile::fake()->image('avatar.png');

    Livewire::test('document-upload', ['category' => 'passport'])
            ->set('file', $file)
            ->call('save');

    expect(Document::count())->toBe(1)
                             ->and(Document::first())
        ->name->toBe('avatar.png')
        ->type->toBe(Document::TYPE_DIGITAL)
        ->path->toBe('documents/'.$this->user->uuid.'/passport.png');
});

it('has consts for document types', function () {
    expect(Document::TYPE_DIGITAL)->toBe(0)
                                  ->and(Document::TYPE_ANALOG)->toBe(1);
});

it('it shows approved status', function () {
    $document = Document::factory()->approved()->withCategory(DocumentCategory::PassportCopy)->make();
    $this->user->documents()->save($document);

    Livewire::test('document-upload', [
        'category' => DocumentCategory::PassportCopy->value,
    ])
            ->assertStatus(200)
            ->assertSee(__('document.state_approved'));
});

it('it shows submitted status', function () {
    $document = Document::factory()->submitted()->withCategory(DocumentCategory::PassportCopy)->make();
    $this->user->documents()->save($document);

    Livewire::test('document-upload', [
        'category' => DocumentCategory::PassportCopy->value,
    ])
            ->assertStatus(200)
            ->assertSee(__('document.state_submitted'));
});

it('it shows not uploaded status', function () {
    Livewire::test('document-upload', [
        'category' => DocumentCategory::PassportCopy->value,
    ])
            ->assertStatus(200)
            ->assertSee(__('document.state_not_uploaded'));
});

it('shows file input for complete form', function () {
    Livewire::test('document-upload', [
        'category' => DocumentCategory::PassportCopy->value,
    ])->assertStatus(200)
            ->assertSee(__('document.state_not_uploaded'))
            ->assertSeeHtml('<input');
});
