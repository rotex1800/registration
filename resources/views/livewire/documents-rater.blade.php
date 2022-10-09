<div class="flex flex-row">
    <div wire:click="download" class="px-2 {{ $document != null ? "underline text-blue-500" : "" }}">
        {{ $category?->displayName() }}
    </div>
    <div class="px-2" wire:click="approve">
        👍
    </div>
    <div class="px-2">
        {{ $this->state() }}
    </div>
    <div class="px-2" wire:click="decline">
        👎
    </div>
</div>
