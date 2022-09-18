@extends('app')
@section('content')
    @livewire('event-registration', ['event' => $event])
@endsection
