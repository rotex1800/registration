<div>
    <select wire:model="currentAttendeeId">
        @foreach($attendees as $attendee)
            <option value="{{ $attendee->id }}">{!! $attendee->full_name !!}</option>
        @endforeach
    </select>

    <div class="text-lg">

        <div>
            <div>{{ __('registration.birthday').': '.($currentAttendee?->birthday?->translatedFormat('d. F Y') ?: '--') }}</div>
            <div>{{ __('registration.gender.gender').': '.($currentAttendee?->gender ?: '--') }}</div>
            <div>{{ __('signup.email').': '.($currentAttendee?->email ?: '--') }}</div>
            <div>{{ __('registration.mobile_phone').': '.($currentAttendee?->mobile_phone ?: '--') }}</div>
            <div>{{ __('registration.health_issues').': '.($currentAttendee?->health_issues ?: '--') }}</div>
        </div>
        <div>
            {{ __('registration.passport') }}
            <div>{{ __('registration.nationality').': '.($currentAttendee?->passport?->nationality ?: '--') }}</div>
            <div>{{ __('registration.passport-number').': '.($currentAttendee?->passport?->passport_number ?: '--') }}</div>
            <div>{{ __('registration.passport-issue-date').': '.($currentAttendee?->passport?->issue_date ?: '--') }}</div>
            <div>{{ __('registration.passport-expiration-date').': '.($currentAttendee?->passport?->expiration_date ?: '--') }}</div>
        </div>

        <div>
            {{ __('registration.about-rotary') }}
            <div>{{ __('registration.rotary.host-club').': '.($currentAttendee?->rotaryInfo?->host_club ?: '--') }}</div>
            <div>{{ __('registration.rotary.host-district').': '.($currentAttendee?->rotaryInfo?->host_district ?: '--') }}</div>
            <div>{{ __('registration.rotary.sponsor-club').': '.($currentAttendee?->rotaryInfo?->sponsor_club ?: '--') }}</div>
            <div>{{ __('registration.rotary.sponsor-district').': '.($currentAttendee?->rotaryInfo?->sponsor_district ?: '--') }}</div>
        </div>

        <div>
            {{ __('registration.about-counselor') }}
            <div>{{ __('registration.counselor.name').': '.($currentAttendee?->counselor?->name ?: '--') }}</div>
            <div>{{ __('registration.counselor.telephone').': '.($currentAttendee?->counselor?->phone ?: '--') }}</div>
            <div>{{ __('registration.counselor.email').': '.($currentAttendee?->counselor?->email?: '--') }}</div>
        </div>

        <div>
            {{ __('registration.about-yeo') }}
            <div>{{ __('registration.yeo.name').': '.($currentAttendee?->yeo?->name ?: '--') }}</div>
            <div>{{ __('registration.yeo.telephone').': '.($currentAttendee?->yeo?->phone ?: '--') }}</div>
            <div>{{ __('registration.yeo.email').': '.($currentAttendee?->yeo?->email?: '--') }}</div>
        </div>

        <div>
            {{ __('registration.about-bio-family') }}
            <div>{{ __('registration.bio-family.parent-one').': '.($currentAttendee?->bioFamily?->parent_one ?: '--') }}</div>
            <div>{{ __('registration.bio-family.parent-two').': '.($currentAttendee?->bioFamily?->parent_two ?: '--') }}</div>
            <div>{{ __('registration.bio-family.email').': '.($currentAttendee?->bioFamily?->email ?: '--') }}</div>
            <div>{{ __('registration.bio-family.telephone').': '.($currentAttendee?->bioFamily?->phone ?: '--') }}</div>
        </div>

        <div>
            {{ __('registration.about-host-family-one') }}
            <div>{{ __('registration.host-family.name').': '.($currentAttendee?->firstHostFamily()?->name ?: '--') }}</div>
            <div>{{ __('registration.host-family.email').': '.($currentAttendee?->firstHostFamily()?->email ?: '--') }}</div>
            <div>{{ __('registration.host-family.phone').': '.($currentAttendee?->firstHostFamily()?->phone ?: '--') }}</div>
            <div>{{ __('registration.host-family.address').': '.($currentAttendee?->firstHostFamily()?->address ?: '--') }}</div>
        </div>

        <div>
            {{ __('registration.about-host-family-two') }}
            <div>{{ __('registration.host-family.name').': '.($currentAttendee?->secondHostFamily()?->name ?: '--') }}</div>
            <div>{{ __('registration.host-family.email').': '.($currentAttendee?->secondHostFamily()?->email ?: '--') }}</div>
            <div>{{ __('registration.host-family.phone').': '.($currentAttendee?->secondHostFamily()?->phone ?: '--') }}</div>
            <div>{{ __('registration.host-family.address').': '.($currentAttendee?->secondHostFamily()?->address ?: '--') }}</div>
        </div>

        <div>
            {{ __('registration.about-host-family-three') }}
            <div>{{ __('registration.host-family.name').': '.($currentAttendee?->thirdHostFamily()?->name ?: '--') }}</div>
            <div>{{ __('registration.host-family.email').': '.($currentAttendee?->thirdHostFamily()?->email ?: '--') }}</div>
            <div>{{ __('registration.host-family.phone').': '.($currentAttendee?->thirdHostFamily()?->phone ?: '--') }}</div>
            <div>{{ __('registration.host-family.address').': '.($currentAttendee?->thirdHostFamily()?->address ?: '--') }}</div>
        </div>
    </div>
</div>
