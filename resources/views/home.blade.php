@extends('app')
@section('content')
    @if(count($participating) > 0)
        <div class="flex text-4xl mb-3">Meine Events</div>
        @foreach($participating as $event)
            <livewire:event-summary :event="$event" wire:key="event-summary-{{ $event->id }}"/>
        @endforeach
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
    <div class="flex text-4xl mt-6 mb-3">{{ __('Available downloads') }}</div>
    <p>Für die EuropaTour brauchst Du einige Informationen von uns wir auch von Dir. Hier bekommst Du den
        Informationsflyer,
        sowie die Vorlage für APPF und Verhaltensregeln.</p>
    <ul class="ml-5 list-disc leading-loose">
        <li>
            Hier findest du die Zusammenfassung der wichtigsten Informationen.
            <livewire:file-download :type="\App\Models\DownloadableFileType::Flyer"/>
        </li>
        <li>
            Das sind die Grundregeln die auf der Tour gelten. Du musst sie akzeptieren und unterschreiben um mitfahren
            zu können.
            <livewire:file-download :type="\App\Models\DownloadableFileType::Rules"/>
        </li>
        <li>
            Mit diesem Dokument bestätigen deine Erziehungsberechtigten, dein YEO und deine Gasteltern, dass du mit uns
            reisen darfst.
            <livewire:file-download :type="\App\Models\DownloadableFileType::APPF"/>
        </li>
    </ul>
@endsection
