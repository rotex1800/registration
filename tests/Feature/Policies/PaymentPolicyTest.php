<?php

namespace Tests\Feature\Policies;

use App\Policies\PaymentPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows rotex user to create payment', function () {
    $user = createUserWithRole('rotex');
    expect((new PaymentPolicy())->createPayment($user))
        ->toBeAllowed();
});

it('denies other users to create payment', function () {
    $user = createUserWithRole('other');
    expect((new PaymentPolicy())->createPayment($user))
        ->toBeDenied();
});

it('denies guest to create payment', function () {
    expect((new PaymentPolicy())->createPayment(null))
        ->toBeDenied();
});
