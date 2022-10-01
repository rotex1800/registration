<?php

use App\Models\Passport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has nationality', function () {
    $passport = Passport::factory()->create();
    expect($passport->nationality)->toBeString();
});

it('has passport number', function () {
    expect(Passport::factory()->create()->passport_number)
        ->toBeString();
});

it('has issue date', function () {
    expect(Passport::factory()->create()->issue_date)
        ->toBeInstanceOf(Carbon::class);
});

it('has expiration date', function () {
    expect(Passport::factory()->create()->expiration_date)
        ->toBeInstanceOf(Carbon::class);
});

it('belongs to user', function () {
    $user = User::factory()->create();
    $passport = Passport::factory()->create();
    $user->passport()->save($passport);
    $user->save();

    expect($passport->user())
        ->toBeInstanceOf(BelongsTo::class)
        ->and($passport->user)
        ->toBeInstanceOf(User::class);
});

test('dates are cast correctly', function () {
    $passport = Passport::factory()->create();
    expect($passport->getCasts()['issue_date'])
        ->toBe('date:Y-m-d')
        ->and($passport->getCasts()['expiration_date'])->toBe('date:Y-m-d');
});
