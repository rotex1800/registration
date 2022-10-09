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

    public $extraRowLivewire = '';

    public function render()
    {
        return view('livewire.sortable-table')->with([
            'rows' => $this->rows,
            'columns' => $this->columns,
            'extraRowLivewire' => $this->extraRowLivewire,
        ]);
    }
}
