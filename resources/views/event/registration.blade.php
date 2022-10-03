@extends('app')
@section('content')
    @livewire('event-registration', ['event' => $event, 'activePart' => $part])
@endsection
