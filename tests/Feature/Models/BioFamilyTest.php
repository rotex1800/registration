<?php

use App\Models\BioFamily;
use App\Models\HasCompletnessCheck;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->family = BioFamily::factory()->create();
});

it('has parent one', function () {
    expect($this->family->parent_one)
        ->toBeString();
});

it('has parent two', function () {
    expect($this->family->parent_two)
        ->toBeString();
});

it('has phone', function () {
    expect($this->family->phone)
        ->toBeString();
});

it('has email', function () {
    expect($this->family->email)
        ->toBeString();
});

it('implements completeness check', function () {
    $result = in_array(HasCompletnessCheck::class, class_uses_recursive(BioFamily::class));
    expect($result)->toBeTrue();
});
