<div class="w-full h-16 bg-blue-800 flex flex-row items-center p-2 space-x-2">
    <div class="text-white align-middle">{{ $applicationName }}</div>
    <div class="w-3"></div>
    <div wire:click.prevent="toHome" class="text-white align-middle cursor-pointer">Home</div>
    <div class="text-white text-right align-middle grow">{{ $name }}</div>
    @if($loggedIn)
        <div wire:click.prevent="logout" class="text-white text-right align-middle m-4 cursor-pointer">Logout</div>
    @endif
</div>
