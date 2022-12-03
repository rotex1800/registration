<?php

namespace Tests\Models;

use App\Models\DocumentState;

it('creates Submitted state from submitted', function () {
    expect(DocumentState::from('submitted'))
        ->toBe(DocumentState::Submitted);
});

it('creates Approved state from approved', function () {
    expect(DocumentState::from('approved'))
        ->toBe(DocumentState::Approved);
});

it('creates Declined state from declined', function () {
    expect(DocumentState::from('declined'))
        ->toBe(DocumentState::Declined);
});

it('creates Missing state from missing', function () {
    expect(DocumentState::from('missing'))
        ->toBe(DocumentState::Missing);
});

test('states are ordered correctly', function () {
    $missing = DocumentState::Missing;
    $declined = DocumentState::Declined;
    $submitted = DocumentState::Submitted;
    $approved = DocumentState::Approved;
    expect(
        $missing->compareTo($missing)
    )->toBe(0)
     ->and($missing->compareTo($declined))->toBe(-1)
     ->and($missing->compareTo($submitted))->toBe(-1)
     ->and($missing->compareTo($approved))->toBe(-1)
     ->and($declined->compareTo($missing))->toBe(1)
     ->and($declined->compareTo($declined))->toBe(0)
     ->and($declined->compareTo($submitted))->toBe(-1)
     ->and($declined->compareTo($approved))->toBe(-1)
     ->and($submitted->compareTo($missing))->toBe(1)
     ->and($submitted->compareTo($declined))->toBe(1)
     ->and($submitted->compareTo($submitted))->toBe(0)
     ->and($submitted->compareTo($approved))->toBe(-1)
     ->and($approved->compareTo($missing))->toBe(1)
     ->and($approved->compareTo($declined))->toBe(1)
     ->and($approved->compareTo($submitted))->toBe(1)
     ->and($approved->compareTo($approved))->toBe(0);
});

it('can sort an array of states', function () {
    $original = [
        DocumentState::Approved,
        DocumentState::Declined,
        DocumentState::Submitted,
        DocumentState::Submitted,
        DocumentState::Missing,
    ];

    $expected = [
        DocumentState::Missing,
        DocumentState::Declined,
        DocumentState::Submitted,
        DocumentState::Submitted,
        DocumentState::Approved,
    ];

    expect(DocumentState::sort($original))
        ->toBe($expected);
});
