@php use App\Models\Comment;use Illuminate\Support\Collection; @endphp
@props([
    /** @var Collection<Comment>|null $comments */
    'comments'
])

@foreach(($comments ?: []) as $comment)
    <div {{ $attributes->class(['even:bg-slate-200 odd:bg-slate-300 rounded-lg p-2 mb-1']) }}>
        <div class="flex flex-row justify-between">
            <div class="text-sm">{{ $comment->author->comment_display_name }}</div>
            <div class="text-sm">{{ $comment->created_at->timezone(config('app.timezone'))->translatedFormat('d. F Y H:i') }}</div>
        </div>
        <div>
            {{ $comment->content }}
        </div>
    </div>
@endforeach
<div class="flex flex-row w-full mt-2">
    <input placeholder="{{ __('document-comments.comment-placeholder') }}"
           class="block w-auto grow rounded-lg"
           type="text"
           wire:keydown.enter="saveComment"
           wire:model.live.debounce.500ms="comment">
    <button class="ml-2 p-2 bg-blue-500 text-white rounded-lg"
            wire:click="saveComment">{{ __('document-comments.comment') }}</button>
</div>
