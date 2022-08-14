<div class="bg-white p-4 rounded-lg shadow-lg flex flex-col">
    <div class="text-2xl m-2">{{ $this->event->name }}</div>
    <div class="m-1 ml-2 flex flex-row">
        <div class="mr-2">Von:</div>
        <div>{{ $this->event->start->isoFormat('d. MMMM Y') }}</div>
    </div>
    <div class="m-1 ml-2 flex flex-row">
        <div class="mr-2">Bis:</div>
        <div>{{ $this->event->end->isoFormat('d. MMMM Y') }}</div>
    </div>
    <button wire:click="show" class="bg-blue-800 text-white rounded p-2 m-2">Details</button>
</div>
