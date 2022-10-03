<div class="mt-4">
    <form wire:submit.prevent="save">
        <h2 class="text-2xl mb-2">{{ $displayName }}</h2>
        @error('file') <span class="error">{{ $message }}</span> @enderror
        <input wire:model="file" class="form-input rounded" id="file" type="file">
        <button class="rounded bg-blue-500 p-3 text-white font-bold" type="submit">{{ __('document.upload') }}</button>
    </form>
    <div>{{ $state }}</div>
</div>
