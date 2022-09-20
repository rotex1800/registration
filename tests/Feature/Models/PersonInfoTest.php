<?php

use App\Models\PersonInfo;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->info = PersonInfo::factory()->create();
});

it('has name', function () {
    expect($this->info->name)
        ->toBeString();
});

it('has email', function () {
    expect($this->info->email)
        ->toBeString();
});

it('has phone', function () {
    expect($this->info->phone)
        ->toBeString();
});

it('belongs to user', function () {
    expect($this->info->user())
        ->toBeInstanceOf(BelongsTo::class);
    $user = User::factory()->create();
    $user->counselor()->save($this->info);
    expect($user->counselor)
        ->toBeInstanceOf(PersonInfo::class)
        ->toBeSameEntityAs($this->info);

});
