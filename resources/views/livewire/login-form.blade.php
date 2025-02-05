<div class="grid place-items-center h-full">
    <div class="bg-slate-200 p-8 rounded-lg shadow-lg">

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form class="grid gap-4 grid-flow-row" wire:submit="login" method="post">
            @csrf
            <label>E-Mail
                <input wire:model.live="email"
                       type="email"
                       name="email"
                       id="email"
                       placeholder="E-Mail"
                       class="rounded-sm w-full focus:shadow-sm">
            </label>
            <label>Passwort
                <input wire:model.live="password"
                       type="password"
                       name="password"
                       id="password"
                       placeholder="Passwort"
                       class="input-form rounded-sm w-full focus:shadow-sm">
            </label>
            <label>
                {{ __('Stay logged in') }}
                <input type="checkbox"
                       name="remember"
                       class="ml-2 rounded-sm align-middle"
                       wire:model.live="remember">
            </label>
            <button type="submit"
                    class="p-2 rounded-sm bg-blue-600 hover:bg-blue-500 h-11 text-white">{{ __('Login') }}
            </button>
            <a class="underline text-blue-500"
               href="{{ route('password.request') }}">{{ __('signup.forgot-password') }}</a>
        </form>
    </div>
</div>
