<?php

namespace App\Http\Livewire;

use Closure;

class SortableTableColumn
{
    private string $header;

    private Closure $supplier;

    public function __construct(string $header, Closure $supplier)
    {
        $this->header = strval($header);
        $this->supplier = $supplier;
    }

    public function header(): string
    {
        return $this->header;
    }

    public function valueFor(mixed $params): mixed
    {
        return call_user_func($this->supplier, $params);
    }
}
