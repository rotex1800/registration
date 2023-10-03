<?php

namespace App\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class LoginForm extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    /**
     * @var array|string[]
     */
    protected array $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function render(): Application|Factory|View
    {
        return view('livewire.login-form');
    }

    public function login(): Redirector
    {
        $this->validate();

        if (Auth::attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )) {
            return redirect()->route('home');
        }

        return redirect()->route('login');
    }
}
