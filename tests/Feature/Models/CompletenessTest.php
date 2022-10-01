<?php

use App\Models\BioFamily;
use App\Models\CounselorInfo;
use App\Models\HasCompletnessCheck;
use App\Models\HostFamily;
use App\Models\Passport;
use App\Models\RegistrationComment;
use App\Models\RotaryInfo;
use App\Models\User;
use App\Models\YeoInfo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/*
 * Nationality, Passport Number, Issue data, expiration date
 */
/**
 * @param  Factory  $factory
 * @param  array  $attrs
 * @return void
 */
function assertCompletenessCheck(Factory $factory): void
{
    $attrs = $factory->definition();
    $model = $factory->state($attrs)->make();
    /** @noinspection PhpPossiblePolymorphicInvocationInspection */
    expect($model->isComplete())->toBeTrue();

    foreach (array_keys($attrs) as $attribute) {
        $model = $factory->state($attrs)
                         ->state([
                             $attribute => null,
                         ])
                         ->make();
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        expect($model->isComplete())->toBeFalse();
    }
}

test('models implement completeness check', function () {
    $models = [
        Passport::class,
        RotaryInfo::class,
        CounselorInfo::class,
        BioFamily::class,
        YeoInfo::class,
        HostFamily::class,
        RegistrationComment::class,
        User::class,
    ];
    foreach ($models as $model) {
        $result = in_array(HasCompletnessCheck::class, class_uses_recursive($model));
        expect($result)->toBeTrue();
    }
});

test('models are complete with required attributes', function () {
    assertCompletenessCheck(Passport::factory());
    assertCompletenessCheck(RotaryInfo::factory());
    assertCompletenessCheck(CounselorInfo::factory());
    assertCompletenessCheck(YeoInfo::factory());
    assertCompletenessCheck(BioFamily::factory());
    assertCompletenessCheck(HostFamily::factory());
    assertCompletenessCheck(RegistrationComment::factory());
    // Test for completeness of a user in UserTest.
});
