@extends('app')
@section('content')
    @if(count($events) > 0)
        <div class="text-4xl">Meine Events</div>
        <div class="flex space-x-4">
            @foreach($events as $event)
                <livewire:event-summary :event="$event" wire:key="event-summary-{{ $event->id }}"/>
            @endforeach
        </div>
    @endif
    @if(count($otherEvents) > 0)
        <div class="text-4xl">Weitere Events</div>
        @foreach($otherEvents as $event)
            <livewire:event-summary :event="$event" wire:key="other-event-summary-{{ $event->id }}"/>
        @endforeach
    @endif
@endsection
