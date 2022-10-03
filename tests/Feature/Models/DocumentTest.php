<?php

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentState;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has a type', function () {
    expect(Document::factory()->create()->type)
        ->toBeInt();
});

it('has a name', function () {
    expect(Document::factory()->create()->name)
        ->toBeString();
});

it('can be required', function () {
    expect(Document::factory()->create()->is_required)
        ->toBeBool();
});

it('can be approved', function () {
    expect(Document::factory()->approved()->create()->isApproved())
        ->toBeBool()
        ->toBeTrue();
});

it('can be submitted', function () {
    expect(Document::factory()
                   ->submitted()
                   ->create()
                   ->isSubmitted()
    )->toBeBool()
     ->toBeTrue();
});

it('has path', function () {
    expect(Document::factory()->make()->path)
        ->toBeString();
});

it('returns false for isSubmitted if it is already approved', function () {
    expect(Document::factory()
                   ->approved()
                   ->create()
                   ->isSubmitted()
    )->toBeFalse();
});

it('is owned by a user', function () {
    $document = Document::factory()->create();
    expect($document->owner())
        ->toBeInstanceOf(BelongsTo::class)
        ->and($document->owner)
        ->toBeInstanceOf(User::class);
});

it('is child of a polymorphic relation', function () {
    $doc = Document::factory()->create();
    expect($doc->documentable())
        ->toBeInstanceOf(MorphTo::class);
});

test('factory can create digital document', function () {
    $doc = Document::factory()->digital()->make();
    expect($doc->type)->toBe(Document::TYPE_DIGITAL);
});

test('factory can create approved document', function () {
    $doc = Document::factory()->approved()->make();
    expect($doc->state)->toBackEnumCase(DocumentState::Approved);
});

test('factory can create submitted document', function () {
    $doc = Document::factory()->submitted()->make();
    expect($doc->state)->toBackEnumCase(DocumentState::Submitted);
});

test('factory can create document with the given DocumentCategory', function () {
    $doc = Document::factory()->withCategory(DocumentCategory::PassportCopy)->create();
    expect($doc)
        ->toBeInstanceOf(Document::class)
        ->category->toBeString()->toBe(DocumentCategory::PassportCopy->value);
});

test('category is unique', function () {
    $first = Document::factory()->withCategory(DocumentCategory::PassportCopy)->make();
    $second = Document::factory()->withCategory(DocumentCategory::PassportCopy)->make();

    $first->save();
    $second->save();

})->throws(QueryException::class);

test('category can be null multiple times', function () {
    $first = Document::factory()->state(['category' => null])->make();
    $second = Document::factory()->state(['category' => null])->make();
    $first->save();
    $second->save();
});
