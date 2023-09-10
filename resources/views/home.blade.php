@extends('app')
@section('content')
    @if(count($participating) > 0)
        <div class="text-4xl mb-3">Meine Events</div>
        <div class="flex space-x-4">
            @foreach($participating as $event)
                <livewire:event-summary :event="$event" wire:key="event-summary-{{ $event->id }}"/>
            @endforeach
        </div>
    @endif
    @if(count($registrationPossible) > 0)
        <div class="flex text-4xl mt-6 mb-3">{{ __('Available events') }}</div>
        @foreach($registrationPossible as $event)
            <livewire:event-summary :event="$event" wire:key="other-event-summary-{{ $event->id }}"/>
        @endforeach
    @endif

    @can('seeRegistrations', App\Models\Event::class)
        <div class="flex text-4xl mt-6 mb-3">Anmeldungen</div>
        @if(count($allEvents) > 0)
            @foreach($allEvents as $event)
                <a class="text-xl" href="{{ route('registrations.show', $event) }}">Anmeldungen
                    für {{ $event->name }}</a>
            @endforeach
        @else
            <p>Derzeit gibt es keine offenen Anmeldungen</p>
        @endif
    @endcan
@endsection
