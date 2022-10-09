<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SortableTable extends Component
{
    /**
     * @var SortableTableColumn[]
     */
    public array $columns = [];

    /**
     * @var object[]
     */
    public array $rows = [];

    public function render()
    {
        return view('livewire.sortable-table');
    }
}
