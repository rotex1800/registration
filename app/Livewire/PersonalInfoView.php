<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\View\Factory;
use Illuminate\View\View;
use Livewire\Component;

class PersonalInfoView extends Component
{
    use HasCommentSection;

    /**
     * @var User|null
     */
    public $currentAttendee;

    public function mount(): void
    {
        $this->commentable = $this->currentAttendee?->additionalInfo?->firstOrCreate();
        $this->comments = $this->currentAttendee?->additionalInfo?->comments;
    }

    public function render(): View|Factory
    {
        return view('livewire.personal-info-view');
    }
}
