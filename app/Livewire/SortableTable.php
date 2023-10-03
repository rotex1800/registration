<?php

namespace App\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SortableTable extends Component
{
    /**
     * @var SortableTableColumn[]
     */
    private array $columns = [];

    /**
     * @var object[]
     */
    private array $rows = [];

    private string $extraRowLivewire = '';

    /**
     * @param  SortableTableColumn[]  $columns
     * @param  object[]  $rows
     */
    public function mount(array $columns = [], array $rows = [], string $extraRowLivewire = ''): void
    {
        $this->rows = $rows;
        $this->columns = $columns;
        $this->extraRowLivewire = $extraRowLivewire;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.sortable-table')->with([
            'rows' => $this->rows,
            'columns' => $this->columns,
            'extraRowLivewire' => $this->extraRowLivewire,
        ]);
    }
}
