<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\SortableTable;
use App\Http\Livewire\SortableTableColumn;
use App\Models\User;
use Arr;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('can render component', function () {
    $component = Livewire::test(SortableTable::class);
    $component->assertStatus(200);
});

it('can contain additional row', function () {
    $columns = [
        new SortableTableColumn('Column 1', function ($value) {
            return $value->full_name;
        }),
    ];
    $rows = [User::factory()->make()];
    Livewire::test('sortable-table', [
        'columns' => $columns,
        'rows' => $rows,
        'extraRowLivewire' => 'documents-table-row',
    ])->assertSee(__('registration.rules'));
});

it('does not contain additional row by default', function () {
    $columns = [
        new SortableTableColumn('Column 1', function ($value) {
            return $value->full_name;
        }),
    ];
    $rows = [User::factory()->make()];
    Livewire::test('sortable-table', [
        'columns' => $columns,
        'rows' => $rows,
    ])->assertDontSee('Dokumente');
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
