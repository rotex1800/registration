<div>
    <div class="text-2xl">{{ __('registration.about-person') }}</div>
    <div>{{ __('event.registration-overview.full-name').': '.$currentAttendee?->full_name }}</div>
    <div>{{ __('registration.birthday').': '.($currentAttendee?->birthday?->translatedFormat('d. F Y') ?: '--') }}</div>
    <div>{{ __('registration.gender.gender').': '.($currentAttendee?->gender ?: '--') }}</div>
    <div>{{ __('signup.email').': '.($currentAttendee?->email ?: '--') }}</div>
    <div>{{ __('registration.mobile_phone').': '.($currentAttendee?->mobile_phone ?: '--') }}</div>
    <div>{{ __('registration.tshirt-size').': '.($currentAttendee?->additionalInfo?->tshirt_size?->displayName() ?: '--') }}</div>
    <div>{{ __('registration.allergies').': '.($currentAttendee?->additionalInfo?->allergies ?: '--') }}</div>
    <div>{{ __('registration.diet').': '.($currentAttendee?->additionalInfo?->diet ?: '--') }}</div>
    <div>{{ __('registration.health_issues').': '.($currentAttendee?->health_issues ?: '--') }}</div>
    <div>{{ __('registration.desired_group').': '.($currentAttendee?->additionalInfo?->desired_group ?: '--') }}</div>
    <x-comment-section
        :comments="$currentAttendee?->additionalInfo?->comments"
        wire:key="{{ $currentAttendee->id.'personal-data-comments' }}"
    />
</div>
