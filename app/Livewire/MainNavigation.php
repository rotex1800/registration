<?php

namespace App\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class MainNavigation extends Component
{
    public mixed $applicationName;

    public string $name;

    public bool $loggedIn;

    public function mount(): void
    {
        $this->loggedIn = Auth::user() != null;
    }

    public function render(): Application|Factory|View
    {
        $this->applicationName = config('app.name');
        $this->name = Auth::user()?->first_name ?: '';

        return view('livewire.main-navigation');
    }

    public function logout(): RedirectResponse|Redirector
    {
        Auth::logout();

        return redirect()->route('login');
    }

    public function toHome(): Redirector
    {
        return redirect()->route('home');
    }

    public function toRegister(): Redirector
    {
        return redirect()->route('register');
    }

    public function toLogin(): Redirector
    {
        return redirect()->route('login');
    }
}
