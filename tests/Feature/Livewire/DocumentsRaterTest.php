<?php

namespace Tests\Feature\Livewire;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentState;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->category = DocumentCategory::SchoolCertificate;
    $this->user = User::factory()->create();
    $this->document = Document::factory()
                              ->submitted()
                              ->withCategory($this->category)
                              ->make();

    $this->user->documents()->save($this->document);
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
    expect($this->document->refresh()->state)
        ->toBe(DocumentState::Approved);
});

it('can decline document', function () {
    $this->component
        ->call('decline');

    expect($this->document->refresh()->state)
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
