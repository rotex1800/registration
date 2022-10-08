<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Redirector;

class MainNavigation extends Component
{
    public string $applicationName;

    public string $name;

    public bool $loggedIn;

    public function mount(): void
    {
        $this->loggedIn = Auth::user() != null;
    }

    public function render(): Application|Factory|View
    {
        $this->applicationName = config('app.name');
        $this->name = Auth::user()?->full_name ?: '';

        return view('livewire.main-navigation');
    }

    public function logout(): RedirectResponse|Redirector
    {
        Auth::logout();

        return redirect()->route('login');
    }

    public function toHome(): RedirectResponse|Redirector
    {
        return redirect()->route('home');
    }

    public function toRegister(): RedirectResponse|Redirector
    {
        return redirect()->route('register');
    }

    public function toLogin(): RedirectResponse|Redirector
    {
        return redirect()->route('login');
    }
}
