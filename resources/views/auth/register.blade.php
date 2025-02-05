@extends('app')

@section('content')
    <div class="grid place-items-center h-full">
        <div class="bg-slate-200 p-8 rounded-lg shadow-lg">
            <form method="post" action="{{ route('register') }}" class="grid gap-4 grid-flow-row">
                @csrf
                <label>{{__('signup.first-name_s')}}
                    <input type="text"
                           name="first_name"
                           class="rounded-sm w-full focus:shadow-sm"
                    >
                    @error('first_name')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </label>
                <label>{{__('signup.family-name_s')}}
                    <input type="text"
                           name="family_name"
                           class="rounded-sm w-full focus:shadow-sm"
                    >
                    @error('family_name')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </label>
                <label>{{__('signup.email')}}
                    <input type="email"
                           name="email"
                           class="rounded-sm w-full focus:shadow-sm"
                    >
                    @error('email')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </label>
                <label>{{__('signup.password')}}
                    <input type="password"
                           name="password"
                           class="rounded-sm w-full focus:shadow-sm"
                    >
                    @error('password')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </label>
                <label>{{__('signup.password-confirmation')}}
                    <input type="password"
                           name="password_confirmation"
                           class="rounded-sm w-full focus:shadow-sm"
                    >
                    @error('password_confirmation')
                    <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </label>

                <button type="submit" class="p-2 rounded-sm bg-blue-600 hover:bg-blue-500 h-11 text-white">
                    {{__('signup.register')}}
                </button>
            </form>
        </div>
    </div>

@endsection
