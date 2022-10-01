<?php

namespace App\Http\Livewire;

use App\Models\BioFamily;
use App\Models\CounselorInfo;
use App\Models\Event;
use App\Models\HostFamily;
use App\Models\Passport;
use App\Models\RegistrationComment;
use App\Models\RotaryInfo;
use App\Models\User;
use App\Models\YeoInfo;
use App\Policies\EventPolicy;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Redirector;

class EventRegistration extends Component
{
    private const NULLABLE_DATE = 'nullable|date';

    private const NULLABLE = 'nullable';
    private const PART_ONE = 'one';
    private const PART_TWO = 'two';

    public Event $event;

    public RotaryInfo $rotary;

    public array $districts;

    public User $user;

    public Passport $passport;

    public CounselorInfo $counselor;

    public YeoInfo $yeo;

    public BioFamily $bioFamily;

    public ?HostFamily $hostFamilyOne;

    public ?HostFamily $hostFamilyTwo;

    public ?HostFamily $hostFamilyThree;

    public RegistrationComment $comment;

    public string $activePart;

    protected array $rules = [
        'user.first_name' => self::NULLABLE,
        'user.family_name' => self::NULLABLE,
        'user.gender' => 'nullable|in:female,male,diverse,na',
        'user.birthday' => self::NULLABLE_DATE,
        'user.mobile_phone' => self::NULLABLE,
        'user.health_issues' => self::NULLABLE,

        'passport.nationality' => self::NULLABLE,
        'passport.passport_number' => self::NULLABLE,
        'passport.issue_date' => self::NULLABLE_DATE,
        'passport.expiration_date' => self::NULLABLE_DATE,

        'rotary.host_district' => self::NULLABLE,
        'rotary.host_club' => self::NULLABLE,
        'rotary.sponsor_district' => self::NULLABLE,
        'rotary.sponsor_club' => self::NULLABLE,

        'counselor.name' => self::NULLABLE,
        'counselor.phone' => self::NULLABLE,
        'counselor.email' => self::NULLABLE,

        'yeo.name' => self::NULLABLE,
        'yeo.phone' => self::NULLABLE,
        'yeo.email' => self::NULLABLE,

        'bioFamily.parent_one' => self::NULLABLE,
        'bioFamily.parent_two' => self::NULLABLE,
        'bioFamily.email' => self::NULLABLE,
        'bioFamily.phone' => self::NULLABLE,

        'hostFamilyOne.name' => self::NULLABLE,
        'hostFamilyOne.email' => self::NULLABLE,
        'hostFamilyOne.address' => self::NULLABLE,
        'hostFamilyOne.phone' => self::NULLABLE,

        'hostFamilyTwo.name' => self::NULLABLE,
        'hostFamilyTwo.email' => self::NULLABLE,
        'hostFamilyTwo.address' => self::NULLABLE,
        'hostFamilyTwo.phone' => self::NULLABLE,

        'hostFamilyThree.name' => self::NULLABLE,
        'hostFamilyThree.email' => self::NULLABLE,
        'hostFamilyThree.address' => self::NULLABLE,
        'hostFamilyThree.phone' => self::NULLABLE,

        'comment.body' => self::NULLABLE,
    ];

    public function mount()
    {
        $this->districts = json_decode(Storage::disk('local')->get('districts.json'));
        $this->user = Auth::user();
        $this->passport = $this->user->passport()->firstOrNew();
        $this->rotary = $this->user->rotaryInfo()->firstOrNew();
        $this->counselor = $this->user->counselor()->firstOrNew();
        $this->yeo = $this->user->yeo()->firstOrNew();
        $this->bioFamily = $this->user->bioFamily()->firstOrNew();
        $this->hostFamilyOne = $this->user->firstHostFamily();
        $this->hostFamilyTwo = $this->user->secondHostFamily();
        $this->hostFamilyThree = $this->user->thirdHostFamily();
        $this->comment = $this->user->registrationComment()->firstOrNew();
        $this->activePart = self::PART_ONE;
    }

    public function showPartOne()
    {
        $this->activePart = self::PART_ONE;
    }

    public function showPartTwo()
    {
        $this->activePart = self::PART_TWO;
    }

    public function isPartOneActive(): bool
    {
        return $this->activePart == self::PART_ONE;
    }

    public function isPartTwoActive(): bool
    {
        return $this->activePart == self::PART_TWO;
    }

    public function render(): View
    {
        return view('livewire.event-registration');
    }

    public function hasUserRegistered(): bool
    {
        return $this->user->hasRegisteredFor($this->event);
    }

    public function register(): void
    {
        $this->user->events()->attach($this->event);
        $this->user->save();
    }

    public function unregister(): void
    {
        $this->user->events()->detach($this->event);
        $this->user->save();
    }

    public function canEdit(): bool
    {
        $policy = new EventPolicy();

        return $policy->canEditEvent($this->user)->allowed();
    }

    public function edit(): Redirector|RedirectResponse
    {
        return redirect()->route('event.edit', [
            'event' => $this->event->id,
        ]);
    }

    public function updatedUser()
    {
        $this->user->save();
    }

    public function updatedPassport()
    {
        $this->user->passport()->save($this->passport);
    }

    public function updatedRotary()
    {
        $this->user->rotaryInfo()->save($this->rotary);
    }

    public function updatedCounselor()
    {
        $this->user->counselor()->save($this->counselor);
    }

    public function updatedYeo()
    {
        $this->user->yeo()->save($this->yeo);
    }

    public function updatedBioFamily()
    {
        $this->user->bioFamily()->save($this->bioFamily);
    }

    public function updatedHostFamilyOne()
    {
        $this->hostFamilyOne->order = 1;
        $this->user->hostFamilies()->save($this->hostFamilyOne);
    }

    public function updatedHostFamilyTwo()
    {
        $this->hostFamilyTwo->order = 2;
        $this->user->hostFamilies()->save($this->hostFamilyTwo);
    }

    public function updatedHostFamilyThree()
    {
        $this->hostFamilyThree->order = 3;
        $this->user->hostFamilies()->save($this->hostFamilyThree);
    }

    public function updatedComment()
    {
        $this->user->registrationComment()->save($this->comment);
    }
}
