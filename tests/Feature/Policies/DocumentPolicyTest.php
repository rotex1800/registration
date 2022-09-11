<?php

use App\Policies\DocumentPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows approval for user of role "rotex"', function () {
    $user = createUserWithRole('rotex');
    $policy = new DocumentPolicy();

    expect($policy->canApprove($user))
        ->toBeAllowed();
});

it('denies approval for user of role "participant"', function () {
    $user = createUserWithRole('participant');
    $policy = new DocumentPolicy();

    expect($policy->canApprove($user))
        ->toBeDenied()
        ->message()->toBe('You are not allowed to approve this document');
});
