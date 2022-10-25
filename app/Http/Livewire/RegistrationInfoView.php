<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class RegistrationInfoView extends Component
{
    /**
     * @var Collection<int, User>
     */
    public $attendees;

    /**
     * @var ?int;
     */
    public $currentAttendeeId;

    /**
     * @var ?User
     */
    public $currentAttendee;

    public function mount(): void
    {
        if ($this->attendees != null && count($this->attendees) > 0) {
            $first = $this->attendees[0];
            $this->currentAttendeeId = $first?->id;
            $this->currentAttendee = $first;
        } else {
            $this->attendees = Collection::empty();
        }
    }

    public function render(): View|Factory
    {
        return view('livewire.registration-info-view')->with([
            'attendees' => $this->attendees,
        ]);
    }

    /**
     * @param  int  $id
     * @return void
     */
    public function updatedCurrentAttendeeId(int $id): void
    {
        $newCurrent = $this->attendees->firstWhere('id', '=', $id);
        if ($newCurrent != null) {
            $this->currentAttendee = $newCurrent;
        }
    }
}
