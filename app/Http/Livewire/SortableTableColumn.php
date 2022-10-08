<?php

namespace App\Http\Livewire;

use Closure;

class SortableTableColumn
{
    private string $header;

    private Closure $supplier;

    public function __construct($header, Closure $supplier)
    {
        $this->header = $header;
        $this->supplier = $supplier;
    }

    public function header(): string
    {
        return $this->header;
    }

    public function valueFor($params)
    {
        return call_user_func($this->supplier, $params);
    }
}
