@props([
    /** @var \null */
    'comments'
])
@foreach($comments as $comment)
    <div {{ $attributes->class(['even:bg-slate-200 odd:bg-slate-300 rounded-lg p-2 mb-1']) }}>
        <div class="flex flex-row justify-between">
            <div class="text-sm">{{ $comment->author->full_name }}</div>
            <div class="text-sm">{{ $comment->created_at->translatedFormat('d. F Y H:i') }}</div>
        </div>
        <div>
            {{ $comment->content }}
        </div>
    </div>
@endforeach
<div class="flex flex-row w-full mt-2">
    <input placeholder="{{ __('document-comments.comment-placeholder') }}" class="block w-auto grow" type="text"
           wire:model.debounce.500ms="comment">
    <button class="ml-2 p-2 bg-blue-500 text-white rounded"
            wire:click="saveComment">{{ __('document-comments.comment') }}</button>
</div>
