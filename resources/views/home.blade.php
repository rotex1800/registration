@extends('app')
@section('content')
    <div class="text-4xl">Meine Events</div>
    <div class="flex space-x-4">
        @foreach($events as $event)
            <livewire:event-summary :event="$event" wire:key="event-summary-{{ $event->id }}"/>
        @endforeach
    </div>
@endsection