<?php

use App\Policies\EventPolicy;

beforeEach(function () {
    $this->cut = new EventPolicy();
});

it('denies a user with "rotex" role to edit an event', function () {
    $user = createUserWithRole('rotex');
    expect($this->cut->canEditEvent($user))->toBeAllowed();
});

it('denies a user with "other" role to edit an event', function () {
    $user = createUserWithRole('other');
    expect($this->cut->canEditEvent($user))->toBeDenied();
});

it('denies editing event for a null user', function () {
    expect($this->cut->canEditEvent(null))->toBeDenied();
});
