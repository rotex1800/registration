@extends('app')

@section('content')
    <h1 class="text-4xl">{{ __('signup.update-password') }}</h1>
    <div class="grid place-items-center h-full mt-4">
        <div class="bg-slate-200 p-8 rounded-lg shadow-lg">
            <form class="mt-2" method="post" action="{{ route('password.update') }}">
                @csrf

                <label>{{ __('signup.email') }}
                    <input
                        type="email"
                        name="email"
                        placeholder="E-Mail"
                        class="rounded w-full focus:shadow">
                </label>

                <label>{{ __('signup.password') }}
                    <input
                        type="password"
                        name="password"
                        placeholder="{{ __('signup.new-password') }}"
                        class="rounded w-full focus:shadow">
                    @error('password')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </label>

                <label>{{ __('signup.password-confirmation') }}
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="{{ __('signup.new-password-confirmation') }}"
                        class="rounded w-full focus:shadow">
                </label>

                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <button class="bg-blue-500 rounded p-4 font-semibold text-white mt-2"
                        type="submit">{{ __('signup.update-password') }}</button>
            </form>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

        </div>
    </div>
@endsection
