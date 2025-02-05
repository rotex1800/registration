@extends('app')

@section('content')
    <h1 class="text-4xl">{{ __('signup.verify-email') }}</h1>
    <p>{{ __('signup.verify-email-explanation') }}</p>
    <form class="mt-2" method="post" action="{{ route('verification.send') }}">
        @csrf
        <button class="bg-blue-500 rounded-sm p-4 font-semibold text-white"
                type="submit">{{ __('signup.resend-verification-email') }}</button>
    </form>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('signup.verify-email-resent') }}
        </div>
    @endif
@endsection
