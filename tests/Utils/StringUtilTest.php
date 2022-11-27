<?php

use App\Utils\StringUtil;

it('can get first character of each word', function () {
    $string = 'Lorem ipsum dolor sit amet';

    $actual = StringUtil::firstCharacterOfEachWord($string);

    expect($actual)
        ->toBe('LIDSA');
});
