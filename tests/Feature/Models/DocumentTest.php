<?php

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    expect(Document::factory()->create()->is_approved)
    ->toBeBool();
});

it('is owned by a user', function () {
    $document = Document::factory()->create();
    expect($document->owner())
    ->toBeInstanceOf(BelongsTo::class)
    ->and($document->owner)
    ->toBeInstanceOf(User::class);
});
