<?php

namespace Tests\Feature\Livewire;

use App\Models\AdditionalInfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {

    $this->addtionalInfo = AdditionalInfo::factory([
        'tshirt_size' => 'M',
    ])
        ->for(User::factory([
            'birthday' => '1970-01-01',
            'gender' => 'female',
        ]))
        ->create();
    $this->attendee = $this->addtionalInfo->user;
    $this->component = Livewire::test(
        'personal-info-view',
        [
            'currentAttendee' => $this->attendee,
        ]
    );
});

it('can render', function () {
    $this->component->assertStatus(200);
});

it('shows the full name', function () {
    $this->component->assertSeeText($this->attendee->full_name);
});

it('shows the birthday', function () {
    $this->component->assertSeeText('01. Januar 1970');
});

it('shows the gender', function () {
    $this->component->assertSeeText('female');
});

it('shows the email', function () {
    $this->component->assertSeeText($this->attendee->email);
});

it('shows the mobile phone number', function () {
    $this->component->assertSeeText($this->attendee->mobile_phone);
});

it('shows the tshirt size', function () {
    $this->component->assertSeeText($this->attendee->additionalInfo->tshirt_size);
});

it('shows the allergies', function () {
    $this->component->assertSeeText($this->attendee->additionalInfo->allergies);
});

it('shows the diet', function () {
    $this->component->assertSeeText($this->attendee->additionalInfo->diet);
});

it('shows the health issues', function () {
    $this->component->assertSeeText($this->attendee->health_issues);
});

it('shows the desired group', function () {
    $this->component->assertSeeText($this->attendee->additionalInfo->desired_group);
});
