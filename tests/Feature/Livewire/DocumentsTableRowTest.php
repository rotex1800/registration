<?php

namespace Tests\Feature\Livewire;

use App\Livewire\DocumentsTableRow;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\View\ViewException;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('can render', function () {
    $component = Livewire::test(DocumentsTableRow::class, [
        'user' => User::factory()->create(),
    ]);
    $component->assertStatus(200);
});

it('requires a user parameter', function () {
    Livewire::test(DocumentsTableRow::class);
})->throws(ViewException::class);

it('contains rules', function () {
    Livewire::test(DocumentsTableRow::class, [
        'user' => User::factory()->create(),
    ])
        ->assertSeeText(__('registration.rules'));
});
