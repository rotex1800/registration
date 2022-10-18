<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DocumentsTableRow extends Component
{
    public User $user;

    public function render(): Factory|View|Application
    {
        return view('livewire.documents-table-row');
    }
}
