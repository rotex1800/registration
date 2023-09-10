<?php

namespace App\Http\Livewire;

use App\Models\DownloadableFileType;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileDownload extends Component
{
    /**
     * @var DownloadableFileType
     */
    public $type;

    public function render(): View
    {
        return view('livewire.file-download', ['type' => $this->type]);
    }

    public function download(): ?StreamedResponse
    {
        return Storage::disk('public')->download($this->type->path(), $this->type->displayName());
    }
}
