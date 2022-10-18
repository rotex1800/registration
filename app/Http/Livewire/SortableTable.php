<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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

    public string $extraRowLivewire = '';

    public function render(): Factory|View|Application
    {
        return view('livewire.sortable-table')->with([
            'rows' => $this->rows,
            'columns' => $this->columns,
            'extraRowLivewire' => $this->extraRowLivewire,
        ]);
    }
}
