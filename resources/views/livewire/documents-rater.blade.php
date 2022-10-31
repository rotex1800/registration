<div class="mb-4">
    <div wire:click="download" class="px-2 {{ $document != null ? "underline text-blue-500" : "" }}">
        {{ $category?->displayName() }}
    </div>
    <div class="flex flex-row">
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
    <div class="h-2"></div>
    @if($document != null)
        <x-comment-section :comments="$comments"/>
    @endif
</div>
