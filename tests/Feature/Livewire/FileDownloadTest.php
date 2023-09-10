<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\FileDownload;
use App\Models\DownloadableFileType;
use Livewire\Livewire;

it('can render ', function () {
    Livewire::test(FileDownload::class, [
        'type' => DownloadableFileType::APPF,
    ])
        ->assertOk()
        ->assertSee('APPF')
        ->assertMethodWired('download');
});

it('provides download to file', function () {
    foreach (DownloadableFileType::cases() as $type) {
        Livewire::test(FileDownload::class, [
            'type' => $type,
        ])
            ->assertOk()
            ->call('download')
            ->assertOk();
    }
});
