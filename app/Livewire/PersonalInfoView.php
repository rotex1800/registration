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
     * @var User
     */
    public $currentAttendee;

    public function mount(): void
    {
        $additionalInfo = $this->currentAttendee->additionalInfo();
        $this->commentable = $additionalInfo->firstOrCreate();
        $this->comments = $this->commentable->comments;
    }

    public function render(): View|Factory
    {
        return view('livewire.personal-info-view');
    }
}
