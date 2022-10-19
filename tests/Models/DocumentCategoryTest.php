<?php

use App\Models\DocumentCategory;

it('returns PassportCopy for passport', function () {
    $actual = DocumentCategory::read('passport');
    expect($actual)->toBe(DocumentCategory::PassportCopy);
});

it('returns `passport` for `PassportCopy` case', function () {
    expect(DocumentCategory::PassportCopy->value)->toBe('passport');
});

it('returns `unknown` for `Unknown` case', function () {
    expect(DocumentCategory::Unknown->value)->toBe('unknown');
});

it('creates `PassportCopy` from `passport`', function () {
    expect(DocumentCategory::read('passport'))->toBe(DocumentCategory::PassportCopy);
});

it('creates `Unkown` from `null`', function () {
    expect(DocumentCategory::read(null))->toBe(DocumentCategory::Unknown);
});

it('returns translation for each case', function () {
    expect(DocumentCategory::Rules->displayName())
        ->toBe(__('registration.rules'))
        ->and(DocumentCategory::InsurancePolice->displayName())->toBe(__('registration.insurance-policy'))
        ->and(DocumentCategory::Motivation->displayName())->toBe(__('registration.motivation'))
        ->and(DocumentCategory::PassportCopy->displayName())->toBe(__('registration.passport-copy'))
        ->and(DocumentCategory::Picture->displayName())->toBe(__('registration.picture'))
        ->and(DocumentCategory::ResidencePermit->displayName())->toBe(__('registration.residence-permit'))
        ->and(DocumentCategory::SchoolCertificate->displayName())->toBe(__('registration.school-certificate'))
        ->and(DocumentCategory::Unknown->displayName())->toBe('unknown');
});
