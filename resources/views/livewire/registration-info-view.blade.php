@php use App\Models\DocumentCategory; @endphp
<div>
    <label>
        {{ __('registrations.selected') }}
        <select wire:model="currentPosition">
            @foreach($attendees as $index => $attendee)
                <option
                    value="{{ $index }}">{!! $attendee->overallDocumentState()->displayName().' '.$attendee->full_name !!}</option>
            @endforeach
        </select>
    </label>

    <div class="flex flex-row my-2">
        @if($this->hasPrevious())
            <span wire:click="goToPrevious" class="flex-none underline text-blue-500">
                {{ __('registrations.previous') }}</span>
        @endif
        <span class="grow"></span>
        @if($this->hasNext())
            <span wire:click="goToNext" class="flex-none underline text-blue-500">{{ __('registrations.next') }}</span>
        @endif
    </div>

    <div class="text-lg mt-4 grid gap-4 grid-cols-1 lg:grid-cols-2">
        <div>
            <div class="text-2xl">{{ __('registration.about-person') }}</div>
            <div>{{ __('event.registration-overview.full-name').': '.$currentAttendee?->full_name }}</div>
            <div>{{ __('registration.birthday').': '.($currentAttendee?->birthday?->translatedFormat('d. F Y') ?: '--') }}</div>
            <div>{{ __('registration.gender.gender').': '.($currentAttendee?->gender ?: '--') }}</div>
            <div>{{ __('signup.email').': '.($currentAttendee?->email ?: '--') }}</div>
            <div>{{ __('registration.mobile_phone').': '.($currentAttendee?->mobile_phone ?: '--') }}</div>
            <div>{{ __('registration.tshirt-size').': '.($currentAttendee?->clothesInfo?->tshirt_size ?: '--') }}</div>
            <div>{{ __('registration.health_issues').': '.($currentAttendee?->health_issues ?: '--') }}</div>
        </div>
        <div>
            <div class="text-2xl">{{ __('registration.passport') }}</div>
            <div>{{ __('registration.nationality').': '.($currentAttendee?->passport?->nationality ?: '--') }}</div>
            <div>{{ __('registration.passport-number').': '.($currentAttendee?->passport?->passport_number ?: '--') }}</div>
            <div>{{ __('registration.passport-issue-date').': '.($currentAttendee?->passport?->issue_date ?: '--') }}</div>
            <div>{{ __('registration.passport-expiration-date').': '.($currentAttendee?->passport?->expiration_date ?: '--') }}</div>
        </div>
        <div>
            <div class="text-2xl">{{ __('registration.about-rotary') }}</div>
            <div>{{ __('registration.rotary.host-club').': '.($currentAttendee?->rotaryInfo?->host_club ?: '--') }}</div>
            <div>{{ __('registration.rotary.host-district').': '.($currentAttendee?->rotaryInfo?->host_district ?: '--') }}</div>
            <div>{{ __('registration.rotary.sponsor-club').': '.($currentAttendee?->rotaryInfo?->sponsor_club ?: '--') }}</div>
            <div>{{ __('registration.rotary.sponsor-district').': '.($currentAttendee?->rotaryInfo?->sponsor_district ?: '--') }}</div>
        </div>
        <div>
            <div class="text-2xl">{{ __('registration.about-counselor') }}</div>
            <div>{{ __('registration.counselor.name').': '.($currentAttendee?->counselor?->name ?: '--') }}</div>
            <div>{{ __('registration.counselor.telephone').': '.($currentAttendee?->counselor?->phone ?: '--') }}</div>
            <div>{{ __('registration.counselor.email').': '.($currentAttendee?->counselor?->email?: '--') }}</div>
        </div>
        <div>
            <div class="text-2xl"> {{ __('registration.about-yeo') }}</div>
            <div>{{ __('registration.yeo.name').': '.($currentAttendee?->yeo?->name ?: '--') }}</div>
            <div>{{ __('registration.yeo.telephone').': '.($currentAttendee?->yeo?->phone ?: '--') }}</div>
            <div>{{ __('registration.yeo.email').': '.($currentAttendee?->yeo?->email?: '--') }}</div>
        </div>
        <div>
            <div class="text-2xl">{{ __('registration.about-bio-family') }}</div>
            <div>{{ __('registration.bio-family.parent-one').': '.($currentAttendee?->bioFamily?->parent_one ?: '--') }}</div>
            <div>{{ __('registration.bio-family.parent-two').': '.($currentAttendee?->bioFamily?->parent_two ?: '--') }}</div>
            <div>{{ __('registration.bio-family.email').': '.($currentAttendee?->bioFamily?->email ?: '--') }}</div>
            <div>{{ __('registration.bio-family.telephone').': '.($currentAttendee?->bioFamily?->phone ?: '--') }}</div>
        </div>
        <div>
            <div class="text-2xl">       {{ __('registration.about-host-family-one') }}</div>
            <div>{{ __('registration.host-family.name').': '.($currentAttendee?->firstHostFamily()?->name ?: '--') }}</div>
            <div>{{ __('registration.host-family.email').': '.($currentAttendee?->firstHostFamily()?->email ?: '--') }}</div>
            <div>{{ __('registration.host-family.phone').': '.($currentAttendee?->firstHostFamily()?->phone ?: '--') }}</div>
            <div>{{ __('registration.host-family.address').': '.($currentAttendee?->firstHostFamily()?->address ?: '--') }}</div>
        </div>
        <div>
            <div class="text-2xl">{{ __('registration.about-host-family-two') }}</div>
            <div>{{ __('registration.host-family.name').': '.($currentAttendee?->secondHostFamily()?->name ?: '--') }}</div>
            <div>{{ __('registration.host-family.email').': '.($currentAttendee?->secondHostFamily()?->email ?: '--') }}</div>
            <div>{{ __('registration.host-family.phone').': '.($currentAttendee?->secondHostFamily()?->phone ?: '--') }}</div>
            <div>{{ __('registration.host-family.address').': '.($currentAttendee?->secondHostFamily()?->address ?: '--') }}</div>
        </div>
        <div>
            <div class="text-2xl">{{ __('registration.about-host-family-three') }}</div>
            <div>{{ __('registration.host-family.name').': '.($currentAttendee?->thirdHostFamily()?->name ?: '--') }}</div>
            <div>{{ __('registration.host-family.email').': '.($currentAttendee?->thirdHostFamily()?->email ?: '--') }}</div>
            <div>{{ __('registration.host-family.phone').': '.($currentAttendee?->thirdHostFamily()?->phone ?: '--') }}</div>
            <div>{{ __('registration.host-family.address').': '.($currentAttendee?->thirdHostFamily()?->address ?: '--') }}</div>
        </div>
        <div class="text-2xl flex col-span-full">{{ __('document.documents') }}</div>
        @if($currentAttendee != null)
            @foreach(DocumentCategory::cases() as $category)
                @if($category != DocumentCategory::Unknown)
                    <livewire:documents-rater :user="$currentAttendee" :category="$category"
                                              wire:key="{{ $currentAttendee->id.$category->value }}"/>
                @endif
            @endforeach
        @endif
    </div>
</div>
