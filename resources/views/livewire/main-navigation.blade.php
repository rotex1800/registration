<div class="w-full h-16 bg-blue-700 flex flex-row items-center p-2 space-x-2">
    <div class="text-white align-middle"
         title="Version: {{ config('app.version') }}">{{ strval($applicationName) }}
    </div>
    <div class="w-3"></div>
    @auth('web')
        <div wire:click.prevent="toHome" class="text-white align-middle cursor-pointer p-2 rounded-sm bg-blue-600 hover:bg-blue-500">{{ __('Home') }}</div>
    @else
        <div wire:click.prevent="toLogin"
             class="p-2 rounded-sm bg-blue-600 hover:bg-blue-500 text-white align-middle cursor-pointer">{{ __('signup.login') }}</div>
        <div wire:click.prevent="toRegister"
             class="p-2 rounded-sm bg-blue-600 hover:bg-blue-500 text-white align-middle cursor-pointer">{{ __('signup.register') }}</div>
    @endauth
    <div class="align-bottom grow"></div>
    <div class="text-white text-right align-middle p-2">{{ $name }}</div>
    @auth
        <div wire:click.prevent="logout" class="text-white text-right align-middle m-4 cursor-pointer bg-blue-800 hover:bg-blue-900 rounded-sm p-2">{{ __('Logout') }}</div>
    @endauth
</div>
