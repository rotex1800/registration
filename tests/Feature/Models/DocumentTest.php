<?php

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
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
    expect(Document::factory()->create([
        'state' => Document::APPROVED,
    ])->isApproved())
        ->toBeBool()
        ->toBeTrue();
});

it('can be submitted', function () {
    expect(Document::factory()->create([
        'state' => Document::SUBMITTED,
    ])->isSubmitted())
        ->toBeBool()
        ->toBeTrue();
});

it('has path', function () {
    expect(Document::factory()->make()->path)
        ->toBeString();
});

it('returns false for isSubmitted if it is already approved', function () {
    expect(Document::factory()->create(['state' => Document::APPROVED])->isSubmitted())
        ->toBeFalse();
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
