<div class="mb-4">

    @if($this->isDocumentPresent())

        <div wire:click="download" class="px-2 {{ $commentable != null ? "underline text-blue-500" : "" }}">
            {{ $category?->displayName() }}
        </div>
    @endif
    <div class="px-2">
        {{ $category?->displayName() }}
    </div>
    <div class=" flex flex-row">
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
    <x-comment-section :comments="$this->commentable->comments"/>
</div>
