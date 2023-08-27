<?php

namespace Tests\Feature\Livewire;

use App\Models\AdditionalInfo;
use App\Models\BioFamily;
use App\Models\ClothesSize;
use App\Models\CounselorInfo;
use App\Models\Event;
use App\Models\HostFamily;
use App\Models\Passport;
use App\Models\RotaryInfo;
use App\Models\User;
use App\Models\YeoInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('can render', function () {
    $event = Event::factory()->create();
    $attendees = User::factory()->count(10)->make();
    $event->attendees()->saveMany($attendees);

    Livewire::test('registration-info-view', [
        'event' => $event,
        'attendees' => $attendees,
    ])->assertOk();
});

it('shows full names and overall state of all registered attendees in select', function () {
    createUserWithRole('rotex');
    $event = Event::factory()->create();
    $attendees = User::factory()->count(10)
        ->has(Passport::factory())
        ->has(RotaryInfo::factory())
        ->has(YeoInfo::factory(), 'yeo')
        ->has(CounselorInfo::factory(), 'counselor')
        ->has(BioFamily::factory())
        ->has(HostFamily::factory()->nth(1))
        ->has(HostFamily::factory()->nth(2))
        ->has(HostFamily::factory()->nth(3))
        ->create()
        ->sortBy([['first_name', 'asc'], ['family_name', 'asc']])
        ->values();
    $event->attendees()->saveMany($attendees);

    $fullNames = $attendees->map(function ($e) {
        return $e->overallDocumentState()->displayName().' '.$e->full_name;
    })->toArray();

    Livewire::test('registration-info-view', [
        'attendees' => $attendees,
        'event' => $event,
    ])
        ->assertSeeInOrder($fullNames, false);
});

it('has attendee preselected', function () {
    $user = createUserWithRole('rotex');
    $event = Event::factory()->create();
    $attendees = User::factory()->count(1)
        ->has(Passport::factory())
        ->has(RotaryInfo::factory())
        ->has(YeoInfo::factory(), 'yeo')
        ->has(CounselorInfo::factory(), 'counselor')
        ->has(BioFamily::factory())
        ->has(HostFamily::factory()->nth(1))
        ->has(HostFamily::factory()->nth(2))
        ->has(HostFamily::factory()->nth(3))
        ->create();
    $event->attendees()->saveMany($attendees);

    actingAs($user);
    $component = Livewire::test('registration-info-view', [
        'event' => $event,
    ]);
    $component
        ->assertOk()
        ->assertSee($attendees->first()?->full_name, escape: false);

    $currentAttendee = $component->get('currentAttendee');
    expect($currentAttendee)->toBeSameEntityAs($attendees->first());
});

it('shows attributes of currently selected attendee', function () {
    $attendees = User::factory()->count(2)
        ->has(Passport::factory())
        ->has(RotaryInfo::factory())
        ->has(CounselorInfo::factory(), 'counselor')
        ->has(YeoInfo::factory(), 'yeo')
        ->has(BioFamily::factory())
        ->has(HostFamily::factory()->nth(1))
        ->has(HostFamily::factory()->nth(2))
        ->has(HostFamily::factory()->nth(3))
        ->has(AdditionalInfo::factory()->state(['tshirt_size' => ClothesSize::S]))
        ->create()
        ->sortBy([['first_name', 'asc'], ['family_name', 'asc']])
        ->values();
    $firstAttendee = $attendees[0];
    assert($firstAttendee != null);
    assert($firstAttendee->birthday != null);
    assert($firstAttendee->additionalInfo != null);
    assert($firstAttendee->passport != null);
    assert($firstAttendee->rotaryInfo != null);
    assert($firstAttendee->yeo != null);
    assert($firstAttendee->counselor != null);
    assert($firstAttendee->bioFamily != null);
    $event = Event::factory()->create();
    $event->attendees()->saveMany($attendees);
    $user = createUserWithRole('rotex');
    Livewire::actingAs($user);
    Livewire::test('registration-info-view', [
        'attendees' => $attendees,
        'event' => $event,
    ])
        ->assertOk()
        ->set('currentPosition', 0)
        ->assertSeeInOrder([
            __('event.registration-overview.full-name').': '.$firstAttendee->full_name,
            __('registration.birthday').': '.$firstAttendee->birthday->translatedFormat('d. F Y'),
            __('registration.gender.gender').': '.$firstAttendee->gender,
            __('signup.email').': '.$firstAttendee->email,
            __('registration.mobile_phone').': '.$firstAttendee->mobile_phone,
            __('registration.tshirt-size').': '.$firstAttendee->additionalInfo->tshirt_size->displayName(),
            __('registration.allergies').': '.$firstAttendee->additionalInfo->allergies,
            __('registration.diet').': '.$firstAttendee->additionalInfo->diet,
            __('registration.health_issues').': '.$firstAttendee->health_issues,

            __('registration.passport'),
            __('registration.nationality').': '.$firstAttendee->passport->nationality,
            __('registration.passport-number').': '.$firstAttendee->passport->passport_number,
            __('registration.passport-issue-date').': '.$firstAttendee->passport->issue_date,
            __('registration.passport-expiration-date').': '.$firstAttendee->passport->expiration_date,

            __('registration.about-rotary'),
            __('registration.rotary.host-club').': '.$firstAttendee->rotaryInfo->host_club,
            __('registration.rotary.host-district').': '.$firstAttendee->rotaryInfo->host_district,
            __('registration.rotary.sponsor-club').': '.$firstAttendee->rotaryInfo->sponsor_club,
            __('registration.rotary.sponsor-district').': '.$firstAttendee->rotaryInfo->sponsor_district,

            __('registration.about-counselor'),
            __('registration.counselor.name').': '.$firstAttendee->counselor->name,
            __('registration.counselor.telephone').': '.$firstAttendee->counselor->phone,
            __('registration.counselor.email').': '.$firstAttendee->counselor->email,

            __('registration.about-yeo'),
            __('registration.yeo.name').': '.$firstAttendee->yeo->name,
            __('registration.yeo.telephone').': '.$firstAttendee->yeo->phone,
            __('registration.yeo.email').': '.$firstAttendee->yeo->email,

            __('registration.about-bio-family'),
            __('registration.bio-family.parent-one').': '.$firstAttendee->bioFamily->parent_one,
            __('registration.bio-family.parent-two').': '.$firstAttendee->bioFamily->parent_two,
            __('registration.bio-family.email').': '.$firstAttendee->bioFamily->email,
            __('registration.bio-family.telephone').': '.$firstAttendee->bioFamily->phone,

            __('registration.about-host-family-one'),
            __('registration.host-family.name').': '.$firstAttendee->firstHostFamily()->name,
            __('registration.host-family.email').': '.$firstAttendee->firstHostFamily()->email,
            __('registration.host-family.phone').': '.$firstAttendee->firstHostFamily()->phone,
            __('registration.host-family.address').': '.$firstAttendee->firstHostFamily()->address,

            __('registration.about-host-family-two'),
            __('registration.host-family.name').': '.$firstAttendee->secondHostFamily()->name,
            __('registration.host-family.email').': '.$firstAttendee->secondHostFamily()->email,
            __('registration.host-family.phone').': '.$firstAttendee->secondHostFamily()->phone,
            __('registration.host-family.address').': '.$firstAttendee->secondHostFamily()->address,

            __('registration.about-host-family-three'),
            __('registration.host-family.name').': '.$firstAttendee->thirdHostFamily()->name,
            __('registration.host-family.email').': '.$firstAttendee->thirdHostFamily()->email,
            __('registration.host-family.phone').': '.$firstAttendee->thirdHostFamily()->phone,
            __('registration.host-family.address').': '.$firstAttendee->thirdHostFamily()->address,

        ]);
});

it('can handle user properties being null', function () {
    $event = Event::factory()->create();
    $attendee = User::factory()
        ->state([
            'id' => 1,
            'birthday' => null,
            'gender' => null,
            'mobile_phone' => null,
            'health_issues' => null,
        ])
        ->make();
    $event->attendees()->save($attendee);
    Livewire::test('registration-info-view', [
        'event' => $event,
    ])->assertOk()->assertSee([
        __('registration.birthday').': --',
        __('registration.gender.gender').': --',
        __('registration.mobile_phone').': --',
        __('registration.tshirt-size').': --',
        __('registration.allergies').': --',
        __('registration.diet').': --',
        __('registration.health_issues').': --',
        __('registration.passport-number').': --',
        __('registration.nationality').': --',
        __('registration.passport-issue-date').': --',
        __('registration.passport-expiration-date').': --',
        __('registration.rotary.host-club').': --',
        __('registration.rotary.host-district').': --',
        __('registration.rotary.sponsor-club').': --',
        __('registration.rotary.sponsor-district').': --',
        __('registration.counselor.name').': --',
        __('registration.counselor.telephone').': --',
        __('registration.counselor.email').': --',
        __('registration.yeo.name').': --',
        __('registration.yeo.telephone').': --',
        __('registration.yeo.email').': --',
        __('registration.bio-family.parent-one').': --',
        __('registration.bio-family.parent-two').': --',
        __('registration.bio-family.email').': --',
        __('registration.bio-family.telephone').': --',
        __('registration.host-family.name').': --',
        __('registration.host-family.email').': --',
        __('registration.host-family.phone').': --',
        __('registration.host-family.address').': --',

    ], escape: false);
});

it('has current attendee wired', function () {
    $event = Event::factory()->create();
    $a = User::factory()->create();
    $event->attendees()->save($a);
    Livewire::test('registration-info-view', [
        'event' => $event,
    ])
        ->assertOk()
        ->assertPropertyWired('currentPosition');
});

it('updates the current attendee when updating the current attendee id', function () {
    $attendees = User::factory()
        ->count(2)
        ->create()
        ->sortBy([['first_name', 'asc'], ['family_name', 'asc']])
        ->values();
    $firstAttendee = $attendees[0];
    $secondAttendee = $attendees[1];
    $event = Event::factory()->create();
    $event->attendees()->saveMany($attendees);

    $component = Livewire::test('registration-info-view', [
        'attendees' => $attendees,
        'event' => $event,
    ]);
    $component
        ->assertOk()
        ->set('currentPosition', 0);

    expect($component->get('currentAttendee'))
        ->toBeSameEntityAs($firstAttendee);

    $component->set('currentPosition', 1);
    expect($component->get('currentAttendee'))
        ->toBeSameEntityAs($secondAttendee);
});

it('falls back to empty collection for no attendees', function () {
    $attendees = User::factory()->count(2)->create();
    $firstAttendee = $attendees[0];
    $secondAttendee = $attendees[1];
    $event = Event::factory()->create();

    $component = Livewire::test('registration-info-view', [
        'attendees' => $attendees,
        'event' => $event,
    ]);
    $attendees = $component
        ->assertOk()
        ->get('attendees');

    $currentAttendee = $component
        ->assertOk()
        ->get('currentAttendee');
    expect($currentAttendee)->toBeNull();
    expect($attendees)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(0);
});

it('shows and hides navigation based on current position', function () {
    createUserWithRole('rotex');
    $event = Event::factory()->create();
    $attendees = User::factory()->count(3)
        ->has(Passport::factory())
        ->has(RotaryInfo::factory())
        ->has(YeoInfo::factory(), 'yeo')
        ->has(CounselorInfo::factory(), 'counselor')
        ->has(BioFamily::factory())
        ->has(HostFamily::factory()->nth(1))
        ->has(HostFamily::factory()->nth(2))
        ->has(HostFamily::factory()->nth(3))
        ->create()
        ->sortBy([['first_name', 'asc'], ['family_name', 'asc']])
        ->values();
    $event->attendees()->saveMany($attendees);

    $component = Livewire::test('registration-info-view', [
        'attendees' => $attendees,
        'event' => $event,
    ]);

    $component
        ->assertSee([__('registrations.selected')])

        // Assert first position
        ->assertSee([__('registrations.next')])
        ->assertDontSee([__('registrations.previous')])
        ->assertMethodNotWired('goToPrevious')
        ->assertMethodWired('goToNext')

        // Navigate forward
        ->call('goToNext')

        // Assert middle position
        ->assertSee([
            __('registrations.next'),
            __('registrations.previous'),
        ])
        ->assertMethodWired('goToNext')
        ->assertMethodWired('goToPrevious')

        // Navigate forward
        ->call('goToNext')

        // Assert last position
        ->assertSee([__('registrations.previous')])
        ->assertDontSee([__('registrations.next')])
        ->assertMethodNotWired('goToNext')

        // Navigate backward
        ->call('goToPrevious')

        // Assert middle position
        ->assertSee([
            __('registrations.next'),
            __('registrations.previous'),
        ])
        ->assertMethodWired('goToNext')
        ->assertMethodWired('goToPrevious');
});
