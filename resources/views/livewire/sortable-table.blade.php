<div>
    <table class="border-collapse w-full border border-slate-400 shadow-lg">
        <thead class="bg-slate-400 text-white">
        <tr>
            @foreach($columns as $column)
                <th class="w-auto text-left border-slate-300 font-semibold p-4">{{ $column->header() }} </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $row)
            <tr class="h-8 even:bg-slate-100 odd:bg-slate-200">
                @foreach($columns as $column)
                    <td class="p-4">  {!! $column->valueFor($row) !!}</td>
                @endforeach
            </tr>

            @if( $extraRowLivewire != '')
                <tr class="h-8 even:bg-slate-100 odd:bg-slate-200">
                    <td class="p-4" colspan="100%">
                        @livewire($extraRowLivewire, ['user' => $row], key($loop->index))
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>
