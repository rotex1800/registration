<?php

use App\Models\AdditionalInfo;
use App\Models\PersonInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('database migration is correct', function () {
    $additionalInfo = AdditionalInfo::factory()->create();
    expect($additionalInfo)->not->toBeNull();
});

it('uses personInfo trait', function () {
    $result = in_array(PersonInfo::class, class_uses_recursive(AdditionalInfo::class));
    expect($result)->toBeTrue();
});

it('has t-shirt size', function () {
    $additionalInfo = AdditionalInfo::factory()->make();
    expect($additionalInfo->tshirt_size)
        ->not->toBeEmpty();
});

it('has allergies column', function () {
    $info = AdditionalInfo::factory()->make();
    expect($info->allergies)
        ->toBeString();
});
