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
        <div class="flex text-4xl mt-6 mb-3">Weitere Events</div>
        @foreach($registrationPossible as $event)
            <livewire:event-summary :event="$event" wire:key="other-event-summary-{{ $event->id }}"/>
        @endforeach
    @endif

    @if($canSeeRegistrations)
        <div class="flex text-4xl mt-6 mb-3">Anmeldungen</div>
        @if(count($allEvents) > 0)
            @foreach($allEvents as $event)
                <p class="text-xl">{{ $event->name }}</p>
            @endforeach
        @else
            <p>Derzeit gibt es keine offenen Anmeldungen</p>
        @endif
    @endif
@endsection
