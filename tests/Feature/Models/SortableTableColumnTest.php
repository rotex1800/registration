<?php

use App\Livewire\SortableTableColumn;

it('can be constructed with a string and a closure', function () {
    $column = new SortableTableColumn('Header', function ($params) {
        return $params ? 'true' : 'false';
    });
    expect($column)->not->toBeNull()
        ->header()->toBe('Header')
        ->valueFor(true)->toBe('true')
        ->valueFor(false)->toBe('false');
});

it('fails to construct if the closure is missing', function () {
    /** @noinspection PhpParamsInspection */
    /** @noinspection PhpExpressionResultUnusedInspection */
    new SortableTableColumn(header: 'Header');
})->throws(ArgumentCountError::class);

it('fails to construct if the header is missing', function () {
    /** @noinspection PhpParamsInspection */
    /** @noinspection PhpExpressionResultUnusedInspection */
    new SortableTableColumn(supplier: function () {});
})->throws(ArgumentCountError::class);
