<div class="mt-4">
    <form wire:submit="save">
        <h2 class="text-2xl mb-2">{{ $displayName }}</h2>
        @error('file')
        <div class="text-red-500" class="error">{{ $message }}</div>
        @enderror
        <input wire:model.live="file" class="form-input rounded-sm" id="file" type="file">
        <button class="rounded-sm bg-blue-500 p-3 text-white font-bold" type="submit">{{ __('document.upload') }}</button>
    </form>
    <div class="my-2">{{ $message }}</div>
    @if($document != null)
        <x-comment-section :comments="$comments"/>
    @endif
</div>
