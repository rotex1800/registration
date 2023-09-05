<div class="w-full h-16 bg-blue-800 flex flex-row items-center p-2 space-x-2">
    <div class="text-white align-middle"
         title="Version: {{ config('app.version') }}">{{ strval($applicationName) }}</div>
    <div class="w-3"></div>
    @auth('web')
        <div wire:click.prevent="toHome" class="text-white align-middle cursor-pointer">Home</div>
    @else
        <div wire:click.prevent="toLogin"
             class="text-white align-middle cursor-pointer pr-4">{{ __('signup.login') }}</div>
        <div wire:click.prevent="toRegister"
             class="text-white align-middle cursor-pointer">{{ __('signup.register') }}</div>
    @endauth
    <div class="text-white text-right align-middle grow">{{ $name }}</div>
    @auth
        <div wire:click.prevent="logout" class="text-white text-right align-middle m-4 cursor-pointer">Logout</div>
    @endauth
</div>
