@extends('app')
@section('content')
    @livewire('event-details', ['event' => $event])
@endsection
