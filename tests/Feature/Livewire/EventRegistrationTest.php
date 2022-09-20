<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\EventRegistration;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Livewire\Testing\TestableLivewire;
use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->event = Event::factory()->create();
});

it('shows event information', function () {
    $user = User::factory()->create();
    actingAs($user);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $component
        ->assertSee($this->event->name)
        ->assertSee($this->event->start->isoFormat('d. MMMM Y'))
        ->assertSee($this->event->end->isoFormat('d. MMMM Y'));
});

it('contains button to register if not yet registered', function () {
    $user = User::factory()->create();
    actingAs($user);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component
        ->assertMethodWired('register')
        ->assertSee('Anmelden')
        ->assertDontSee('Abmelden');

    assertFalse(
        $user->hasRegisteredFor($this->event)
    );

    $component
        ->call('register');

    assertTrue(
        $user->hasRegisteredFor($this->event)
    );
});

it('contains button to de-register if already registered', function () {
    $user = User::factory()->create();
    $user->events()->attach($this->event);
    actingAs($user);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component
        ->assertMethodWired('unregister')
        ->assertSee('Abmelden')
        ->assertDontSee('Anmelden');

    $component->call('unregister');

    assertFalse($user->hasRegisteredFor($this->event));
});

it('shows edit button for user with correct role', function () {
    $user = createUserWithRole('rotex');
    $user->events()->attach($this->event);
    actingAs($user);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    actingAs($user);
    $component
        ->assertSee('Bearbeiten')
        ->assertMethodWired('edit');
});

test('edit method redirects to edit page', function () {
    $user = createUserWithRole('rotex');
    $user->events()->attach($this->event);
    actingAs($user);
    Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ])
            ->call('edit')
            ->assertRedirect(route('event.edit', $this->event));
});

it('does not show edit button for user with some role', function () {
    $user = createUserWithRole('role');
    actingAs($user);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component
        ->assertDontSee('Bearbeiten')
        ->assertMethodNotWired('edit');
});

it('has section for information about the person', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component->assertSeeTextInOrder([
        __('registration.about-you'),
        __('registration.first_name'),
        __('registration.family_name'),
        __('registration.birthday'),
        __('registration.gender.gender'),
        __('registration.mobile_phone'),
        __('registration.health_issues'),
    ]);
});

it('has section for information about passport', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $component->assertSeeTextInOrder([
        __('registration.passport'),
        __('registration.nationality'),
        __('registration.passport-number'),
        __('registration.passport-issue-date'),
        __('registration.passport-expiration-date'),
    ]);
});

it('has section for information about rotary', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $component->assertSeeTextInOrder([
        __('registration.about-rotary'),
        __('registration.rotary.host-club'),
        __('registration.rotary.host-district'),
        __('registration.rotary.sponsor-club'),
        __('registration.rotary.sponsor-district'),
    ]);
});

it('has section for information about counselor', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $component->assertSeeTextInOrder([
        __('registration.about-counselor'),
        __('registration.counselor.name'),
        __('registration.counselor.telephone'),
        __('registration.counselor.email'),
    ]);
});

it('has section for information about yeo', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $component->assertSeeTextInOrder([
        __('registration.about-yeo'),
        __('registration.yeo.name'),
        __('registration.yeo.telephone'),
        __('registration.yeo.email'),
    ]);
});

it('has section for family in home country', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $component->assertSeeTextInOrder([
        __('registration.about-bio-family'),
        __('registration.bio-family.parent-one'),
        __('registration.bio-family.parent-two'),
        __('registration.bio-family.email'),
        __('registration.bio-family.telephone'),
    ]);
});

it('has section for first host family', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component->assertSeeTextInOrder([
        __('registration.about-host-family-one'),
        __('registration.host-family.name'),
        __('registration.host-family.email'),
        __('registration.host-family.address'),
    ]);
});

it('has section for second host family', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component->assertSeeTextInOrder([
        __('registration.about-host-family-two'),
        __('registration.host-family.name'),
        __('registration.host-family.email'),
        __('registration.host-family.address'),
    ]);
});

it('has section for third host family', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component->assertSeeTextInOrder([
        __('registration.about-host-family-three'),
        __('registration.host-family.name'),
        __('registration.host-family.email'),
        __('registration.host-family.address'),
    ]);
});

it('has text area for comments', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $component->assertSeeTextInOrder([
        __('registration.comment'),
    ]);
});

it('has user inputs bound to component', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $fakeFirstName = fake()->firstName;
    $fakeLastName = fake()->lastName;
    $fakeGender = fake()->randomElement(['female', 'male', 'diverse', 'na']);
    $fakeBirthday = fake()->date;
    $fakeMobilePhone = fake()->phoneNumber;
    $fakeHealthIssues = fake()->paragraph;

    $component
        ->assertPropertyWired('user.first_name')
        ->assertPropertyWired('user.family_name')
        ->assertPropertyWired('user.birthday')
        ->assertPropertyWired('user.gender')
        ->assertPropertyWired('user.mobile_phone')
        ->assertPropertyWired('user.health_issues')
        ->assertMethodWired('saveUser')
        ->set('user.first_name', $fakeFirstName)
        ->set('user.family_name', $fakeLastName)
        ->set('user.gender', $fakeGender)
        ->set('user.birthday', $fakeBirthday)
        ->set('user.mobile_phone', $fakeMobilePhone)
        ->set('user.health_issues', $fakeHealthIssues)
        ->assertHasNoErrors()
        ->call('saveUser')
        ->assertStatus(200);

    $inbound->refresh();
    expect($inbound->first_name)->toBe($fakeFirstName)
                                ->and($inbound->family_name)->toBe($fakeLastName)
                                ->and($inbound->gender)->toBe($fakeGender)
                                ->and($inbound->birthday->toDateString())->toBe($fakeBirthday)
                                ->and($inbound->mobile_phone)->toBe($fakeMobilePhone)
                                ->and($inbound->health_issues)->toBe($fakeHealthIssues);
});

it('has passport inputs bound to component', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $properties_and_values = [
        'passport.nationality' => fake()->country,
        'passport.passport_number' => fake()->words(asText: true),
        'passport.issue_date' => fake()->date,
        'passport.expiration_date' => fake()->date,
    ];

    foreach ($properties_and_values as $property => $value) {
        assertPropertyTwoWayBound($component, $property, $value);
    }

    $component
        ->assertMethodWired('savePassport')
        ->call('savePassport');

    $inbound->refresh();
    $passport = $inbound->passport()->first();
    expect($passport)->not()->toBeNull()
                     ->and($passport->nationality)->toBe($properties_and_values["passport.nationality"])
                     ->and($passport->passport_number)->toBe($properties_and_values["passport.passport_number"])
                     ->and($passport->issue_date->toDateString())->toBe($properties_and_values["passport.issue_date"])
                     ->and($passport->expiration_date->toDateString())->toBe($properties_and_values["passport.expiration_date"]);

});

/**
 * @param  TestableLivewire  $component
 * @param  string  $property
 * @param  $update_value
 * @return void
 */
function assertPropertyTwoWayBound(TestableLivewire $component, string $property, $update_value): void
{
    $component->assertPropertyWired($property)
              ->set($property, $update_value)
              ->assertHasNoErrors();
}

it('has rotary inputs bound to component', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $properties_and_values = [
        'rotary.host_district' => fake()->words(asText: true),
        'rotary.host_club' => fake()->words(asText: true),
        'rotary.sponsor_district' => fake()->words(asText: true),
        'rotary.sponsor_club' => fake()->words(asText: true),
    ];

    foreach ($properties_and_values as $property => $value) {
        assertPropertyTwoWayBound($component, $property, $value);
    }

    $component
        ->assertMethodWired('saveRotary')
        ->call('saveRotary');

    $inbound->refresh();
    $passport = $inbound->rotaryInfo()->first();
    expect($passport)->not()->toBeNull()
                     ->and($passport->host_district)->toBe($properties_and_values["rotary.host_district"])
                     ->and($passport->host_club)->toBe($properties_and_values["rotary.host_club"])
                     ->and($passport->sponsor_district)->toBe($properties_and_values["rotary.sponsor_district"])
                     ->and($passport->sponsor_club)->toBe($properties_and_values["rotary.sponsor_club"]);
});
