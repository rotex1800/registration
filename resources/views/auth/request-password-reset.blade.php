@extends('app')

@section('content')
    <h1 class="text-4xl">{{ __('signup.forgot-password') }}</h1>
    <p>{{ __('signup.forgot-password-explanation') }}</p>

    <div class="grid place-items-center h-full mt-4">
        <div class="bg-slate-200 p-8 rounded-lg shadow-lg">
            <form class="mt-2" method="post" action="{{ route('password.email') }}">
                @csrf
                <label>{{ __('signup.email') }}
                    <input
                        type="email"
                        name="email"
                        placeholder="E-Mail"
                        class="rounded w-full focus:shadow">
                </label>

                <button class="bg-blue-500 rounded p-4 font-semibold text-white mt-2"
                        type="submit">{{ __('signup.forgot-password-cta') }}</button>
            </form>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

        </div>
    </div>
@endsection
