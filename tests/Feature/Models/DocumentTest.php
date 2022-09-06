<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Document;

uses(RefreshDatabase::class);

it('has a type', function () {
    expect(Document::factory()->create()->type)
    ->toBeInt();
});

it('has a name', function() {
    expect(Document::factory()->create()->name)
    ->toBeString();
});

it('can be required', function() {
    expect(Document::factory()->create()->is_required)
    ->toBeBool();
});

it('can be approved', function() {
    expect(Document::factory()->create()->is_approved)
    ->toBeBool();
});
