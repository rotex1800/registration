@extends('app')
@section('content')
    <div class="text-4xl"> {{ $event->name }}</div>
    <div class="m-1 flex flex-row text-2xl">
        <div class="mr-2">Von:</div>
        <div>{{ $event->start->isoFormat('d. MMMM Y') }}</div>
    </div>
    <div class="m-1 flex flex-row text-2xl">
        <div class="mr-2">Bis:</div>
        <div>{{ $event->end->isoFormat('d. MMMM Y') }}</div>
    </div>
@endsection
