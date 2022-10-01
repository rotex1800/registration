<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\DocumentUpload;
use Livewire\Livewire;
use Tests\TestCase;

class DocumentUploadTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(DocumentUpload::class);

        $component->assertStatus(200);
    }
}
