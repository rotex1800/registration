<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MainNavigation extends Component
{

    public string $applicationName;
    public string $name;
    public bool $loggedIn;


    public function mount()
    {
        $this->loggedIn = Auth::user() != null;
    }

    public function render()
    {
        $this->applicationName = config('app.name');
        $this->name = Auth::user()?->name ?: '';
        return view('livewire.main-navigation');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }


}
