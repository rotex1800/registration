<?php

use App\Models\DocumentCategory;

it('returns PassportCopy for passport', function () {
    $actual = DocumentCategory::from('passport');
    expect($actual)->toBe(DocumentCategory::PassportCopy);
});

it('returns `passport` for `PassportCopy` case', function () {
    expect(DocumentCategory::PassportCopy->value)->toBe('passport');
});

it('returns `unknown` for `Unknown` case', function () {
    expect(DocumentCategory::Unknown->value)->toBe('unknown');
});

it('creates `PassportCopy` from `passport`', function () {
    expect(DocumentCategory::from('passport'))->toBe(DocumentCategory::PassportCopy);
});
