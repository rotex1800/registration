<?php

use App\Models\DocumentCategory;

it('returns PassportCopy for passport', function () {
    $actual = DocumentCategory::createFromString('passport');
    expect($actual)->toBe(DocumentCategory::PassportCopy);
});

it('returns Unknown for unknown category', function () {
    $actual = DocumentCategory::createFromString('foobar');
    expect($actual)->toBe(DocumentCategory::Unknown);
});
