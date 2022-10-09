<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class DocumentsTableRow extends Component
{
    public User $user;

    public function render()
    {
        return view('livewire.documents-table-row');
    }
}
