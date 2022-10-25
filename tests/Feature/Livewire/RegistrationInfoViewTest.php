<?php

namespace Tests\Feature\Livewire;

use Livewire\Livewire;

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

    $this
        ->actingAs($user)
        ->get(route('registrations.show', $event))
        ->assertSeeInOrder(
            Arr::flatten(
                [
                    '<select>',
                    $fullNames,
                    '</select>'
                ])
            , escape: false)
//        ->assertSeeLivewire()
;
});
