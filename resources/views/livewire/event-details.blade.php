<div>
    <div class="text-4xl"> {{ $this->event->name }}</div>
    <div class="flex flex-row">
        <div>
            <div class="my-1 flex flex-row text-2xl">
                <div class="mr-2">Von:</div>
                <div>{{ $this->event->start->isoFormat('d. MMMM Y') }}</div>
            </div>
            <div class="my-1 flex flex-row text-2xl">
                <div class="mr-2">Bis:</div>
                <div>{{ $this->event->end->isoFormat('d. MMMM Y') }}</div>
            </div>
        </div>
    </div>
    <div class="my-1 text-white ">
        @if($this->hasUserRegistered())
            <button class="bg-yellow-500 p-3 rounded" wire:click="unregister">Abmelden</button>
        @else
            <button class="bg-blue-800 p-3 rounded" wire:click="register">Anmelden</button>
        @endif
    </div>
</div>
