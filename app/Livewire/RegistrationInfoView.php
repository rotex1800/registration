<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class RegistrationInfoView extends Component
{
    /**
     * @var Event
     */
    public $event;

    /**
     * @var Collection<int, User>
     */
    public $attendees;

    /**
     * @var ?int;
     */
    public $currentPosition;

    /**
     * @var ?User
     */
    public $currentAttendee;

    public function mount(): void
    {
        $this->attendees = $this
            ->event
            ->attendees
            ->sortBy([['first_name', 'asc'], ['family_name', 'asc']])
            ->values();
        if ($this->attendees != null && count($this->attendees) > 0) {
            $this->currentPosition = 0;
            $this->currentAttendee = $this->attendees->first();
        } else {
            $this->attendees = Collection::empty();
        }
    }

    public function render(): View|Factory
    {
        return view('livewire.registration-info-view');
    }

    public function updatedCurrentPosition(int $position): void
    {
        $newCurrent = $this->attendees->slice($position, 1)->first();
        if ($newCurrent != null) {
            $this->currentAttendee = $newCurrent;
        }
    }

    public function goToPrevious(): void
    {
        if ($this->hasPrevious()) {
            $this->currentPosition = $this->currentPosition - 1;
            $this->currentAttendee = $this->attendees[$this->currentPosition];
        }
    }

    /**
     * Indicates whether there is a previous attendee to show details for.
     */
    public function hasPrevious(): bool
    {
        return ! $this->currentAttendee?->is($this->attendees->first());
    }

    public function goToNext(): void
    {
        if ($this->hasNext()) {
            $this->currentPosition = $this->currentPosition + 1;
            $this->currentAttendee = $this->attendees[$this->currentPosition];
        }
    }

    /**
     * Indicates whether there is a next attendee to show details for.
     */
    public function hasNext(): bool
    {
        return ! $this->currentAttendee?->is($this->attendees->last());
    }
}
