<?php

use App\Models\AdditionalInfo;
use App\Models\PersonInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('database migration is correct', function () {
    $AdditionalInfo = AdditionalInfo::factory()->create();
    expect($AdditionalInfo)->not->toBeNull();
});

it('uses personInfo trait', function () {
    $result = in_array(PersonInfo::class, class_uses_recursive(AdditionalInfo::class));
    expect($result)->toBeTrue();
});

it('has t-shirt size', function () {
    $AdditionalInfo = AdditionalInfo::factory()->make();
    expect($AdditionalInfo->tshirt_size)
        ->not->toBeEmpty();
});
