<?php

use App\Models\ClothesInfo;
use App\Models\PersonInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('database migration is correct', function () {
    $clothesInfo = ClothesInfo::factory()->create();
    expect($clothesInfo)->not->toBeNull();
});

it('uses personInfo trait', function () {
    $result = in_array(PersonInfo::class, class_uses_recursive(ClothesInfo::class));
    expect($result)->toBeTrue();
});

it('has t-shirt size', function () {
    $clothesInfo = ClothesInfo::factory()->make();
    expect($clothesInfo->tshirt_size)
        ->not->toBeEmpty();
});
