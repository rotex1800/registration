<?php

use App\Utils\StringUtil;

it('can get first character of each word', function () {
    $string = 'Lorem ipsum dolor sit amet';

    $actual = StringUtil::firstCharacterOfEachWord($string);

    expect($actual)
        ->toBe('LIDSA');
});

it('handles multiple spaces', function () {
    $two_spaces = 'A  B';
    $three_spaces = 'A   B';

    expect(StringUtil::firstCharacterOfEachWord($two_spaces))
        ->toBe('AB')
        ->and(StringUtil::firstCharacterOfEachWord($three_spaces))
        ->toBe('AB');
});
