<div>
    <div class="text-4xl"> {{ $this->event->name }}</div>
    <div class="flex flex-row">
        <div>
            <div class="my-1 flex flex-row text-2xl">
                <div class="mr-2">Von:</div>
                <div>{{ $this->event->start->isoFormat('d. MMMM Y') }}</div>
            </div>
            <div class="my-1 flex flex-row text-2xl">
                <div class="mr-2">Bis:</div>
                <div>{{ $this->event->end->isoFormat('d. MMMM Y') }}</div>
            </div>
        </div>
    </div>
    <div class="my-1 text-white ">
        @if($this->hasUserRegistered())
            <button class="bg-yellow-500 p-3 rounded" wire:click="unregister">Abmelden</button>
        @else
            <button class="bg-blue-800 p-3 rounded" wire:click="register">Anmelden</button>
        @endif
    </div>
    @if ($this->canEdit())
        <button class="bg-yellow-500 p-3 rounded" wire:click="edit">Bearbeiten</button>
    @endif

    @if($this->hasUserRegistered())
        <h2 class="text-2xl mt-8">{{ __('registration.about-you') }}</h2>
        <div class="mt-4 grid grid-cols-input gap-4 items-center">
            <label for="firstname">{{ __('registration.first_name') }}</label>
            <input class="rounded" type="text" id="firstname" wire:model.debounce="user.first_name">

            <label for="family-name">{{ __('registration.family_name') }}</label>
            <input class="rounded" type="text" id="family-name" wire:model.debounce="user.family_name">

            <label for="birthday">{{ __('registration.birthday') }}</label>
            <input class="rounded" type="date" id="birthday" wire:model.debounce="user.birthday">

            <label for="gender">{{ __('registration.gender.gender') }}</label>
            <select class="rounded" id="gender" wire:model.debounce="user.gender">
                <option value="female">{{ __('registration.gender.female') }}</option>
                <option value="male">{{ __('registration.gender.male') }}</option>
                <option value="diverse">{{ __('registration.gender.diverse') }}</option>
                <option value="na">{{ __('registration.gender.na') }}</option>
            </select>

            <label for="mobile_phone">{{ __('registration.mobile_phone') }}</label>
            <input type="tel" id="mobile_phone" class="rounded" wire:model.debounce="user.mobile_phone">

            <label for="health-issues">{{ __('registration.health_issues') }}</label>
            <textarea class="rounded min-h-40" id="health-issues" wire:model.debounce="user.health_issues"></textarea>

            <button class="col-span-2 text-white bg-blue-800 p-3 rounded" type="button"
                    wire:click.prevent="saveUser">{{ __('registration.save') }}</button>
        </div>

        <h2 class="text-2xl mt-8">{{  __('registration.passport') }}</h2>
        <div class="grid mt-4 grid grid-cols-input gap-4 items-center">
            <label for="nationality">{{ __('registration.nationality') }}</label>
            <input id="nationality" type="text" class="rounded">

            <label for="passport-number">{{ __('registration.passport-number') }}</label>
            <input type="text" id="passport-number" class="rounded">

            <label for="passport-issue-date">{{ __('registration.passport-issue-date') }}</label>
            <input type="date" id="passport-issue-date" class="rounded">

            <label for="passport-expiration-date">{{ __('registration.passport-expiration-date') }}</label>
            <input id="passport-expiration-date" type="date" class="rounded">
        </div>

        <h2 class="text-2xl mt-8">{{ __('registration.about-rotary') }}</h2>
        <div class="grid mt-4 grid grid-cols-input gap-4 items-center">

            <label for="host-club">{{ __('registration.rotary.host-club') }}</label>
            <input id="host-club" class="rounded" type="text">

            <label for="host-district">{{ __('registration.rotary.host-district') }}</label>
            <input id="host-district" type="text" class="rounded">

            <label for="sponsor-club">{{ __('registration.rotary.sponsor-club') }}</label>
            <input id="sponsor-club" type="text" class="rounded">

            <label for="sponsor-district">{{ __('registration.rotary.sponsor-district') }}</label>
            <select class="rounded" id="sponsor-district">
                @foreach($this->districts as $district)
                    <option value="{{$district}}">{{$district}}</option>
                @endforeach
            </select>
        </div>

        <h2 class="text-2xl mt-8">{{ __('registration.about-counselor') }}</h2>
        <div class="grid mt-4 grid grid-cols-input gap-4 items-center">

            <label for="counselor-name">{{ __('registration.counselor.name') }}</label>
            <input id="counselor-name" class="rounded" type="text">

            <label for="counselor-telephone">{{ __('registration.counselor.telephone') }}</label>
            <input id="counselor-telephone" type="tel" class="rounded">

            <label for="counselor-email">{{ __('registration.counselor.email') }}</label>
            <input id="counselor-email" type="email" class="rounded">
        </div>

        <h2 class="text-2xl mt-8">{{ __('registration.about-yeo') }}</h2>
        <div class="grid mt-4 grid grid-cols-input gap-4 items-center">

            <label for="yeo-name">{{ __('registration.yeo.name') }}</label>
            <input id="yeo-name" class="rounded" type="text">

            <label for="yeo-telephone">{{ __('registration.yeo.telephone') }}</label>
            <input id="yeo-telephone" type="tel" class="rounded">

            <label for="yeo-email">{{ __('registration.yeo.email') }}</label>
            <input id="yeo-email" type="email" class="rounded">
        </div>

        <h2 class="text-2xl mt-8">{{ __('registration.about-bio-family') }}</h2>
        <div class="grid mt-4 grid grid-cols-input gap-4 items-center">

            <label for="bio-mother">{{ __('registration.bio-family.parent-one') }}</label>
            <input type="text" id="bio-mother" class="rounded">

            <label for="bio-father">{{ __('registration.bio-family.parent-two') }}</label>
            <input type="text" id="bio-father" class="rounded">

            <label for="bio-email">{{ __('registration.bio-family.email') }}</label>
            <input type="email" id="bio-email" class="rounded">

            <label for="bio-telephone">{{ __('registration.bio-family.telephone') }}</label>
            <input type="tel" id="bio-telephone" class="rounded">
        </div>

        <h2 class="text-2xl mt-8">{{ __('registration.about-host-family-one') }}</h2>
        <div class="grid mt-4 grid grid-cols-input gap-4 items-center">

            <label for="host-name-one">{{ __('registration.host-family.name') }}</label>
            <input type="text" id="host-name-one" class="rounded">

            <label for="host-email-one">{{ __('registration.host-family.email') }}</label>
            <input type="text" id="host-email-one" class="rounded">

            <label for="host-address-one">{{ __('registration.host-family.address') }}</label>
            <input type="text" id="host-address-one" class="rounded">
        </div>

        <h2 class="text-2xl mt-8">{{ __('registration.about-host-family-two') }}</h2>
        <div class="grid mt-4 grid grid-cols-input gap-4 items-center">

            <label for="host-name-two">{{ __('registration.host-family.name') }}</label>
            <input type="text" id="host-name-two" class="rounded">

            <label for="host-email-two">{{ __('registration.host-family.email') }}</label>
            <input type="text" id="host-email-two" class="rounded">

            <label for="host-address-one">{{ __('registration.host-family.address') }}</label>
            <input type="text" id="host-address-one" class="rounded">
        </div>

        <h2 class="text-2xl mt-8">{{ __('registration.about-host-family-three') }}</h2>
        <div class="grid mt-4 grid grid-cols-input gap-4 items-center">

            <label for="host-name-three">{{ __('registration.host-family.name') }}</label>
            <input type="text" id="host-name-three" class="rounded">

            <label for="host-email-three">{{ __('registration.host-family.email') }}</label>
            <input type="text" id="host-email-three" class="rounded">

            <label for="host-address-one">{{ __('registration.host-family.address') }}</label>
            <input type="text" id="host-address-one" class="rounded">
        </div>

        <h2 class="text-2xl mt-8">{{ __('registration.comment') }}</h2>
        <div class="grid mt-4 grid grid-cols-input gap-4 items-center">
            <label for="comment">{{ __('registration.comment') }}</label>
            <textarea class="rounded min-h-40" id="comment"></textarea>
        </div>

    @endif
</div>
