<?php

namespace App\Http\Livewire;

use App\Models\AdditionalInfo;
use App\Models\BioFamily;
use App\Models\CounselorInfo;
use App\Models\Event;
use App\Models\HostFamily;
use App\Models\Passport;
use App\Models\RegistrationComment;
use App\Models\RotaryInfo;
use App\Models\User;
use App\Models\YeoInfo;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class EventRegistration extends Component
{
    private const NULLABLE = 'nullable';

    private const NULLABLE_EMAIL = 'nullable|email';

    private const NULLABLE_PAST_DATE = 'nullable|date|before:today';

    private const NULLABLE_FUTURE_DATE = 'nullable|date|after:today';

    public const PART_ONE = 'one';

    public const PART_TWO = 'two';

    public const KNOWN_PARTS = [
        self::PART_ONE,
        self::PART_TWO,
    ];

    public const NULLABLE_CLOTHES_SIZE = 'nullable|in:NA,XS,S,M,L,XL,XXL,XXXL';

    public Event $event;

    public RotaryInfo $rotary;

    /**
     * @var mixed
     */
    public $districts;

    public User $user;

    public Passport $passport;

    public AdditionalInfo $additionalInfo;

    public CounselorInfo $counselor;

    public YeoInfo $yeo;

    public BioFamily $bioFamily;

    public HostFamily $hostFamilyOne;

    public HostFamily $hostFamilyTwo;

    public HostFamily $hostFamilyThree;

    public RegistrationComment $comment;

    public string $activePart = self::PART_ONE;

    /**
     * @var array<string, array<string, string>>
     */
    protected $queryString = [
        'activePart' => ['as' => 'part'],
    ];

    /**
     * @var array<string, string>
     */
    protected $validationAttributes = [
        'email' => 'E-Mail',
        'today' => 'Heute',
    ];

    /**
     * @var array<string, string>
     */
    protected array $rules = [
        'user.first_name' => self::NULLABLE,
        'user.family_name' => self::NULLABLE,
        'user.gender' => 'nullable|in:female,male,diverse,na',
        'user.birthday' => self::NULLABLE_PAST_DATE,
        'user.mobile_phone' => self::NULLABLE,
        'user.health_issues' => self::NULLABLE,

        'passport.nationality' => self::NULLABLE,
        'passport.passport_number' => self::NULLABLE,
        'passport.issue_date' => self::NULLABLE_PAST_DATE,
        'passport.expiration_date' => self::NULLABLE_FUTURE_DATE,

        'rotary.host_district' => self::NULLABLE,
        'rotary.host_club' => self::NULLABLE,
        'rotary.sponsor_district' => self::NULLABLE,
        'rotary.sponsor_club' => self::NULLABLE,

        'counselor.name' => self::NULLABLE,
        'counselor.phone' => self::NULLABLE,
        'counselor.email' => self::NULLABLE_EMAIL,

        'yeo.name' => self::NULLABLE,
        'yeo.phone' => self::NULLABLE,
        'yeo.email' => self::NULLABLE_EMAIL,

        'bioFamily.parent_one' => self::NULLABLE,
        'bioFamily.parent_two' => self::NULLABLE,
        'bioFamily.email' => self::NULLABLE_EMAIL,
        'bioFamily.phone' => self::NULLABLE,

        'hostFamilyOne.name' => self::NULLABLE,
        'hostFamilyOne.email' => self::NULLABLE_EMAIL,
        'hostFamilyOne.address' => self::NULLABLE,
        'hostFamilyOne.phone' => self::NULLABLE,

        'hostFamilyTwo.name' => self::NULLABLE,
        'hostFamilyTwo.email' => self::NULLABLE_EMAIL,
        'hostFamilyTwo.address' => self::NULLABLE,
        'hostFamilyTwo.phone' => self::NULLABLE,

        'hostFamilyThree.name' => self::NULLABLE,
        'hostFamilyThree.email' => self::NULLABLE_EMAIL,
        'hostFamilyThree.address' => self::NULLABLE,
        'hostFamilyThree.phone' => self::NULLABLE,

        'comment.body' => self::NULLABLE,

        'additionalInfo.tshirt_size' => self::NULLABLE_CLOTHES_SIZE,
        'additionalInfo.allergies' => self::NULLABLE,
        'additionalInfo.diet' => self::NULLABLE,
    ];

    public function mount(): void
    {
        $user = Auth::user();
        if ($user == null) {
            abort(401);
        }

        $content = Storage::disk('local')->get('districts.json') ?? '[]';
        $this->districts = json_decode($content);

        $this->user = $user;
        $this->passport = $this->user->passport()->firstOrNew();
        $this->additionalInfo = $this->user->additionalInfo()->firstOrNew();
        $this->rotary = $this->user->rotaryInfo()->firstOrNew();
        $this->counselor = $this->user->counselor()->firstOrNew();
        $this->yeo = $this->user->yeo()->firstOrNew();
        $this->bioFamily = $this->user->bioFamily()->firstOrNew();
        $this->hostFamilyOne = $this->user->firstHostFamily();
        $this->hostFamilyTwo = $this->user->secondHostFamily();
        $this->hostFamilyThree = $this->user->thirdHostFamily();
        $this->comment = $this->user->registrationComment()->firstOrNew();
    }

    public function showPartOne(): void
    {
        $this->activePart = self::PART_ONE;
    }

    public function showPartTwo(): void
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

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function updatedUser(): void
    {
        $this->user->save();
    }

    public function updatedAdditionalInfo(): void
    {
        $this->user->additionalInfo()->save($this->additionalInfo);
    }

    public function updatedPassport(): void
    {
        $this->user->passport()->save($this->passport);
    }

    public function updatedRotary(): void
    {
        $this->user->rotaryInfo()->save($this->rotary);
    }

    public function updatedCounselor(): void
    {
        $this->user->counselor()->save($this->counselor);
    }

    public function updatedYeo(): void
    {
        $this->user->yeo()->save($this->yeo);
    }

    public function updatedBioFamily(): void
    {
        $this->user->bioFamily()->save($this->bioFamily);
    }

    public function updatedHostFamilyOne(): void
    {
        $this->hostFamilyOne->order = 1;
        $this->user->hostFamilies()->save($this->hostFamilyOne);
    }

    public function updatedHostFamilyTwo(): void
    {
        $this->hostFamilyTwo->order = 2;
        $this->user->hostFamilies()->save($this->hostFamilyTwo);
    }

    public function updatedHostFamilyThree(): void
    {
        $this->hostFamilyThree->order = 3;
        $this->user->hostFamilies()->save($this->hostFamilyThree);
    }

    public function updatedComment(): void
    {
        $this->user->registrationComment()->save($this->comment);
    }
}
