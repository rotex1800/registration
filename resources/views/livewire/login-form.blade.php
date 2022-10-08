<div class="grid place-items-center h-full">
    <div class="bg-slate-200 p-8 rounded-lg shadow-lg">
        <form class="grid gap-4 grid-flow-row" wire:submit.prevent="login" method="post">
            @csrf
            <label>E-Mail
                <input wire:model="email"
                       type="email"
                       name="email"
                       autocomplete="off"
                       id="email"
                       placeholder="E-Mail"
                       class="rounded w-full focus:shadow">
            </label>
            <label>Passwort
                <input wire:model="password"
                       type="password"
                       name="password"
                       id="password"
                       placeholder="Passwort"
                       class="input-form rounded w-full focus:shadow">
            </label>
            <label>
                Login merken
                <input type="checkbox"
                       name="remember"
                       class="rounded"
                       wire:model="remember">
            </label>
            <button type="submit"
                    class="bg-blue-500 rounded h-11 text-white">Login
            </button>
        </form>
    </div>
</div>
