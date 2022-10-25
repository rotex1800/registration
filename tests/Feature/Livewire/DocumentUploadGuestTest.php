<?php

namespace Tests\Feature\Livewire;

use App\Models\DocumentCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire;

uses(RefreshDatabase::class);

it('fails with 401 if user us not authenticated', function () {
    Livewire::test('document-upload', [
        'category' => DocumentCategory::InsurancePolice->value,
    ])->assertUnauthorized();
});
