<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;

class AuthenticationController extends Controller
{
    public function authenticate(LoginRequest $request): RedirectResponse
    {
        $validatedRequest = $request->validated();
        $remember = boolval($request->input('remember'));
        if (Auth::attempt([
            'password' => $request->input('password'),
            Fortify::username() => $request->input(Fortify::username()),
        ], $remember)) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login');
        }
    }
}
