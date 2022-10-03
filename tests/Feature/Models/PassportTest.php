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

it('requires passport number, nationality, issue and expiration date', function () {
    $passport = Passport::factory()->make();
    expect($passport->isComplete())->toBeTrue();

    $passport->passport_number = '';
    expect($passport->isComplete())->toBeFalse();
    $passport->passport_number = fake()->words(asText: true);

    $passport->nationality = '';
    expect($passport->isComplete())->toBeFalse();
    $passport->nationality = fake()->country;

    $passport->issue_date = null;
    expect($passport->isComplete())->toBeFalse();
    $passport->issue_date = fake()->date;

    $passport->expiration_date = null;
    expect($passport->isComplete())->toBeFalse();
    $passport->expiration_date = fake()->date;

    expect($passport->isComplete())->toBeTrue();
});
