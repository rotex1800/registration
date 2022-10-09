@extends('app')
@section('content')
    <h1 class="text-4xl">{{ $event->name }}</h1>

    @if(count($event->attendees) > 0)
        <h2 class="text-2xl my-2" id="registrations">Anmeldungen</h2>
        <livewire:sortable-table :columns="$columns" :rows="$rows" :extra-row-livewire="$extraRowLivewire"/>
    @else
        <p>{{ __('event.registration-overview.no-registrations') }}</p>
    @endif

@endsection
