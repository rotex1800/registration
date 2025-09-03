<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\View\Factory;
use Illuminate\View\View;
use Livewire\Component;

class PersonalInfoView extends Component
{
    /**
     * @var User|null;
     */
    public $currentAttendee;

    public function render(): View|Factory
    {
        return view('livewire.personal-info-view');
    }
}
