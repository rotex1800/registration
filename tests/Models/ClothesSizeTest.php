<?php

namespace Tests\Models;

use App\Models\ClothesSize;
use App\Utils\ValidatableEnum;

it('uses correct backing strings', function () {
    expect(ClothesSize::from('XS'))
        ->toBe(ClothesSize::XS)
        ->and(ClothesSize::from('S'))->toBe(ClothesSize::S)
        ->and(ClothesSize::from('M'))->toBe(ClothesSize::M)
        ->and(ClothesSize::from('L'))->toBe(ClothesSize::L)
        ->and(ClothesSize::from('XL'))->toBe(ClothesSize::XL)
        ->and(ClothesSize::from('XXL'))->toBe(ClothesSize::XXL)
        ->and(ClothesSize::from('XXXL'))->toBe(ClothesSize::XXXL);
});

it('uses `ValidatableEnum` trait', function () {
    $result = in_array(ValidatableEnum::class, class_uses_recursive(ClothesSize::class));
    expect($result)->toBeTrue();
});

it('uses -- as displayname for NA', function () {
    expect(ClothesSize::NA->displayName())->toBe('--');
});
