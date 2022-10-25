<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RegistrationInfoView extends Component
{
    public function render(): View|Factory
    {
        return view('livewire.registration-info-view');
    }
}
