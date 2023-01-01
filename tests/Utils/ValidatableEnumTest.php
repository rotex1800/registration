<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Tests\Utils;

use Exception;

it('can be applied to string backed enums', function () {
    expect(StringBackedTestEnum::inEnumCasesValidationString())
        ->toBe('in:A,B,C');
});


it('can be applied to int backed enums', function () {
    expect(IntBackedTestEnum::inEnumCasesValidationString())
        ->toBe('in:1,2,3');
});

it('can be applied to normal enums', function () {
    expect(NormalTestEnum::inEnumCasesValidationString())
        ->toBe('in:A,B,C');
});

it('can not be applied to other types', function () {
    expect(TestClass::inEnumCasesValidationString());
})->throws(Exception::class);
