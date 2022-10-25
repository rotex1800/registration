<?php

namespace Tests\Feature\Livewire;

use App\Models\BioFamily;
use App\Models\CounselorInfo;
use App\Models\Event;
use App\Models\HostFamily;
use App\Models\Passport;
use App\Models\RotaryInfo;
use App\Models\User;
use App\Models\YeoInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('can render', function () {
    Livewire::test('registration-info-view')
            ->assertOk();
});

it('shows full names of all registered attendees in select', function () {
    $user = createUserWithRole('rotex');
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
                     ->create();
    $event->attendees()->saveMany($attendees);

    $fullNames = $attendees->map(function ($e) {
        return $e->full_name;
    })->toArray();

    Livewire::test('registration-info-view', [
        'attendees' => $attendees,
    ])->assertSee(
        Arr::flatten(
            [
                '<select>',
                $fullNames,
                '</select>',
            ]), escape: false);
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

    Livewire::test('registration-info-view', [
        'attendees' => $attendees,
    ])
            ->assertOk()
            ->assertSee($attendees->first()->full_name);
});
