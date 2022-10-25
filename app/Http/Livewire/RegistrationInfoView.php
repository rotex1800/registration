<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RegistrationInfoView extends Component
{
    /**
     * @var User[]
     */
    public $attendees = [];

    public function render(): View|Factory
    {
        return view('livewire.registration-info-view')->with([
            'attendees' => $this->attendees,
        ]);
    }
}
