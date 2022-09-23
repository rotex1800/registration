<?php

namespace App\Http\Livewire;

use App\Models\CounselorInfo;
use App\Models\Event;
use App\Models\Passport;
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

    public Event $event;

    public RotaryInfo $rotary;

    public array $districts;

    public User $user;

    public Passport $passport;

    public CounselorInfo $counselor;

    public YeoInfo $yeo;

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
    ];

    public function mount()
    {
        $this->districts = json_decode(Storage::disk('local')->get('districts.json'));
        $this->user = Auth::user();
        $this->passport = $this->user->passport()->firstOrNew();
        $this->rotary = $this->user->rotaryInfo()->firstOrNew();
        $this->counselor = $this->user->counselor()->firstOrNew();
        $this->yeo = $this->user->yeo()->firstOrNew();
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

    public function saveUser()
    {
        $this->user->save();
    }

    public function savePassport()
    {
        $this->user->passport()->save($this->passport);
    }

    public function saveRotary()
    {
        $this->user->rotaryInfo()->save($this->rotary);
    }

    public function saveCounselor()
    {
        $this->user->counselor()->save($this->counselor);
    }

    public function saveYeo()
    {
        $this->user->yeo()->save($this->yeo);
    }
}
