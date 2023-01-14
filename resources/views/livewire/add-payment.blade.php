<div>
    <p>Summe: {{ $sum }}</p>
    <div>
        @error('amount')
        <div class="text-red-500">{{ $message }}</div>
        @enderror
    </div>
    <div class="flex flex-row w-full mt-2">

        <input type="text"
               id="amount"
               placeholder="{{ __('payment.amount') }}"
               class="block w-auto grow rounded-lg"
               wire:model.debounce.500ms="amount"
        />
        <button
            class="ml-2 p-2 bg-blue-500 text-white rounded-lg"
            wire:click="addPayment">
            {{ __('common.ok') }}
        </button>
    </div>
</div>
