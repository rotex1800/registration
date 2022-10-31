@php use App\Models\Document; @endphp
@props([
    /** @var Document */
    'document'
])

@foreach($document->comments as $comment)
    <div {{ $attributes->class(['even:bg-slate-200 odd:bg-slate-300 rounded-lg p-2']) }}>
        <div class="flex flex-row justify-between">
            <div class="text-sm">{{ $comment->author->full_name }}</div>
            <div class="text-sm">{{ $comment->created_at->translatedFormat('d. F Y H:m') }}</div>
        </div>
        <div>
            {{ $comment->content }}
        </div>
    </div>
@endforeach
<div class="flex flex-row w-full mt-2">
    <input class="block w-auto grow" type="text" wire:model="comment">
    <button class="ml-2 p-2 bg-blue-500 text-white rounded"
            wire:click="saveComment">{{ __('document-comments.comment') }}</button>
</div>
