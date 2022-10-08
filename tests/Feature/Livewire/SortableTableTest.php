<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\SortableTable;
use App\Http\Livewire\SortableTableColumn;
use App\Models\User;
use Arr;
use Livewire\Livewire;

it('can render component', function () {
    $component = Livewire::test(SortableTable::class);
    $component->assertStatus(200);
});

test('table headlines are configurable', function () {
    $columns = [
        new SortableTableColumn('Column A', function ($value) {
            return $value->full_name;
        }),
        new SortableTableColumn('Column B', function ($value) {
            return $value->full_name;
        }),
        new SortableTableColumn('Column C', function ($value) {
            return $value->full_name;
        }),
    ];
    $rows = [
        User::factory()->make(),
        User::factory()->make(),
        User::factory()->make(),
    ];
    Livewire::test('sortable-table', [
        'columns' => $columns,
        'rows' => $rows,
    ])->assertSeeTextInOrder(Arr::map($columns, function ($elem) {
        return $elem->header();
    }))->assertSeeHtmlInOrder(
        Arr::flatten([
            '<table',
            '<thead',
            '<tr',
            Arr::map($columns, function ($elem) {
                return ['<th', $elem->header(), '</th>'];
            }),
            '</tr>',
            '</thead>',
            '<tbody',
            Arr::map($rows, function ($row) use ($columns) {
                return [
                    '<tr',
                    Arr::map($columns, function ($column) use ($row) {
                        return [
                            '<td',
                            $column->valueFor($row),
                            '</td>',
                        ];
                    }),
                    '</tr>',
                ];
            }),
            '</tbody>',
            '</table>',
        ]));
});