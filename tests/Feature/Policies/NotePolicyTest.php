<?php

namespace Tests\Feature\Policies;

use App\Policies\NotePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows rotex user to create note', function () {
    $user = createUserWithRole('rotex');
    expect((new NotePolicy)->createNote($user))
        ->toBeAllowed();
});

it('denies other users to create note', function () {
    $user = createUserWithRole('other');
    expect((new NotePolicy)->createNote($user))
        ->toBeDenied();
});

it('denies guest to create note', function () {
    expect((new NotePolicy)->createNote(null))
        ->toBeDenied();
});

it('allows rotex user to read note', function () {
    $user = createUserWithRole('rotex');
    expect((new NotePolicy)->createNote($user))
        ->toBeAllowed();
});

it('denies other users to read note', function () {
    $user = createUserWithRole('other');
    expect((new NotePolicy)->readNote($user))
        ->toBeDenied();
});

it('denies guest to read note', function () {
    expect((new NotePolicy)->readNote(null))
        ->toBeDenied();
});

it('denies Authenticatable without HasRoles trait', function () {
    $authenticatable = new TestAuthenticatableWithoutRoles;
    expect((new NotePolicy)->createNote($authenticatable))
        ->toBeDenied();
});
