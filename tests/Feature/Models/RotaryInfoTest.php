<?php

use App\Models\RotaryInfo;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->info = RotaryInfo::factory()->create();
});

it('has host club', function () {
    expect($this->info->host_club)
        ->toBeString();
});

it('has sponsor club', function () {
    expect($this->info->sponsor_club)
        ->toBeString();
});

it('has host district', function () {
    expect($this->info->host_district)
        ->toBeString();
});

it('has sponsor district', function () {
    expect($this->info->sponsor_district)
        ->toBeString();
});

it('belongs to user', function () {
    expect($this->info->user())
        ->toBeInstanceOf(BelongsTo::class);

    $user = User::factory()->create();
    $user->rotaryInfo()->save($this->info);

    expect($this->info->user)
        ->toBeInstanceOf(User::class)
        ->toBeSameEntityAs($user);
});
