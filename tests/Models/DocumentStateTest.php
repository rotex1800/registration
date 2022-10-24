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
