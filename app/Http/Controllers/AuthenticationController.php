<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Http\Requests\LoginRequest;

class AuthenticationController extends Controller
{
    public function authenticate(LoginRequest $request): RedirectResponse
    {
        if (Auth::attempt($request->validated(), $request->input('remember'))) {
            return redirect()->route('home');
        } else {
            return redirect('/login');
        }
    }
}
