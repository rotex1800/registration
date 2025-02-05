@extends('app')

@section('content')
    <h1 class="text-4xl">{{ __('root.welcome') }}</h1>
    <p class="mt-2">{{ __('root.introduction') }}</p>
    <p class="my-2">{{ __('root.help') }}</p>

    <a class="inline-block bg-blue-800 rounded-sm p-2 text-white font-semibold mx-2" href="{{ route('login') }}"
       id="login">{{ __('signup.login') }}</a>
    <a class="inline-block bg-blue-800 rounded-sm p-2 text-white font-semibold" href="{{ route('register') }}"
       id="register">{{ __('signup.register') }}</a>
@endsection
