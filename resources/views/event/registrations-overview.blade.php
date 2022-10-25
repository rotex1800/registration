@extends('app')
@section('content')
    <h1 class="text-4xl">{{ $event->name }}</h1>

    @if(count($event->attendees) > 0)
        <h2 class="text-2xl my-2" id="registrations">Anmeldungen</h2>
        <a class="text-blue-500 underline mb-2 block" href="{{ route('registrations.download', $event) }}">Download</a>
        <livewire:registration-info-view :attendees="$event->attendees"/>
    @else
        <p>{{ __('event.registration-overview.no-registrations') }}</p>
    @endif

@endsection
