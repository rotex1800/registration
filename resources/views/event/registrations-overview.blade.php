@extends('app')
@section('content')
    <h1 class="text-4xl">{{ $event->name }}</h1>

    @if(count($event->attendees) > 0)
        <h2 class="text-2xl my-2" id="registrations">Anmeldungen</h2>
        <table
            class="border-collapse w-full border border-slate-400 shadow-lg"
            aria-describedby="registrations">
            <thead class="bg-slate-400 text-white">
            <tr>
                <th class="w-auto text-left border-slate-300 font-semibold p-4">
                    {{ __('event.registration-overview.full-name') }}</th>
                <th class="w-auto text-left border-slate-300 font-semibold p-4">
                    {{ __('event.registration-overview.email') }}</th>
            </tr>
            </thead>
            <tbody class="px-4">
            @foreach($event->attendees as $attendee)
                <tr class="h-8 even:bg-slate-100 odd:bg-slate-200">
                    <td class="p-4">{{ $attendee->full_name }}</td>
                    <td class="p-4">{{ $attendee->email }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>{{ __('event.registration-overview.no-registrations') }}</p>
    @endif

@endsection
