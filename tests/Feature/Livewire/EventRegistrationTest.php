<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\EventRegistration;
use App\Models\BioFamily;
use App\Models\CounselorInfo;
use App\Models\Event;
use App\Models\HostFamily;
use App\Models\Passport;
use App\Models\RegistrationComment;
use App\Models\RotaryInfo;
use App\Models\User;
use App\Models\YeoInfo;
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
        ->assertSee('Bewerben')
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
        __('registration.host-family.phone'),
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
        __('registration.host-family.phone'),
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
        __('registration.host-family.phone'),
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

it('has comment bound to component', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $comment = fake()->paragraph;
    $component->set('comment.body', $comment);

    $inbound->refresh();
    expect($inbound->registrationComment->body)
        ->toBe($comment);
});

it('shows comment body in text area', function () {
    $inbound = createInboundRegisteredFor($this->event);

    $body = fake()->paragraph;
    $comment = RegistrationComment::factory()->state(['body' => $body])->make();
    $inbound->registrationComment()->save($comment);

    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $component->assertSee($body);
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
        ->set('user.first_name', $fakeFirstName)
        ->set('user.family_name', $fakeLastName)
        ->set('user.gender', $fakeGender)
        ->set('user.birthday', $fakeBirthday)
        ->set('user.mobile_phone', $fakeMobilePhone)
        ->set('user.health_issues', $fakeHealthIssues)
        ->assertHasNoErrors()
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

    $inbound->refresh();
    $passport = $inbound->passport;
    expect($passport)->not()->toBeNull()
                     ->and($passport->nationality)->toBe($properties_and_values['passport.nationality'])
                     ->and($passport->passport_number)->toBe($properties_and_values['passport.passport_number'])
                     ->and($passport->issue_date->toDateString())->toBe($properties_and_values['passport.issue_date'])
                     ->and($passport->expiration_date->toDateString())->toBe($properties_and_values['passport.expiration_date']);
});

/**
 * @param  TestableLivewire  $component
 * @param  string  $property
 * @param    $update_value
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

    $inbound->refresh();
    $passport = $inbound->rotaryInfo;
    expect($passport)->not()->toBeNull()
                     ->and($passport->host_district)->toBe($properties_and_values['rotary.host_district'])
                     ->and($passport->host_club)->toBe($properties_and_values['rotary.host_club'])
                     ->and($passport->sponsor_district)->toBe($properties_and_values['rotary.sponsor_district'])
                     ->and($passport->sponsor_club)->toBe($properties_and_values['rotary.sponsor_club']);
});

it('has rotary counselor bound to component', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $properties_and_values = [
        'counselor.email' => fake()->words(asText: true),
        'counselor.name' => fake()->words(asText: true),
        'counselor.phone' => fake()->words(asText: true),
    ];

    foreach ($properties_and_values as $property => $value) {
        assertPropertyTwoWayBound($component, $property, $value);
    }

    $inbound->refresh();
    $counselor = $inbound->counselor;
    expect($counselor)->not->toBeNull()
                           ->and($counselor->name)->toBe($properties_and_values['counselor.name'])
                           ->and($counselor->phone)->toBe($properties_and_values['counselor.phone'])
                           ->and($counselor->email)->toBe($properties_and_values['counselor.email']);
});

it('has rotary yeo bound to component', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $properties_and_values = [
        'yeo.email' => fake()->words(asText: true),
        'yeo.name' => fake()->words(asText: true),
        'yeo.phone' => fake()->words(asText: true),
    ];

    foreach ($properties_and_values as $property => $value) {
        assertPropertyTwoWayBound($component, $property, $value);
    }

    $inbound->refresh();
    $yeo = $inbound->yeo;
    expect($yeo)->not->toBeNull()
                     ->and($yeo->name)->toBe($properties_and_values['yeo.name'])
                     ->and($yeo->phone)->toBe($properties_and_values['yeo.phone'])
                     ->and($yeo->email)->toBe($properties_and_values['yeo.email']);
});

it('has bio family bound to component', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $properties_and_values = [
        'bioFamily.parent_one' => fake()->words(asText: true),
        'bioFamily.parent_two' => fake()->words(asText: true),
        'bioFamily.email' => fake()->words(asText: true),
        'bioFamily.phone' => fake()->words(asText: true),
    ];

    foreach ($properties_and_values as $property => $value) {
        assertPropertyTwoWayBound($component, $property, $value);
    }

    $inbound->refresh();
    $family = $inbound->bioFamily;
    expect($family)->not->toBeNull()
                        ->and($family->parent_one)->toBe($properties_and_values['bioFamily.parent_one'])
                        ->and($family->parent_two)->toBe($properties_and_values['bioFamily.parent_two'])
                        ->and($family->email)->toBe($properties_and_values['bioFamily.email'])
                        ->and($family->phone)->toBe($properties_and_values['bioFamily.phone']);
});

it('has host families wired to component', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    $properties_and_values = [
        'hostFamilyOne.name' => fake()->words(asText: true),
        'hostFamilyOne.email' => fake()->words(asText: true),
        'hostFamilyOne.phone' => fake()->phoneNumber,
        'hostFamilyOne.address' => fake()->words(asText: true),

        'hostFamilyTwo.name' => fake()->words(asText: true),
        'hostFamilyTwo.email' => fake()->words(asText: true),
        'hostFamilyTwo.phone' => fake()->phoneNumber,
        'hostFamilyTwo.address' => fake()->words(asText: true),

        'hostFamilyThree.name' => fake()->words(asText: true),
        'hostFamilyThree.email' => fake()->words(asText: true),
        'hostFamilyThree.phone' => fake()->phoneNumber,
        'hostFamilyThree.address' => fake()->words(asText: true),
    ];

    foreach ($properties_and_values as $property => $value) {
        assertPropertyTwoWayBound($component, $property, $value);
    }

    $inbound->refresh();
    $family = $inbound->firstHostFamily();
    expect($family)->not->toBeNull()
                        ->and($family->name)->toBe($properties_and_values['hostFamilyOne.name'])
                        ->and($family->email)->toBe($properties_and_values['hostFamilyOne.email'])
                        ->and($family->phone)->toBe($properties_and_values['hostFamilyOne.phone'])
                        ->and($family->address)->toBe($properties_and_values['hostFamilyOne.address']);

    $inbound->refresh();
    $family = $inbound->secondHostFamily();
    expect($family)->not->toBeNull()
                        ->and($family->name)->toBe($properties_and_values['hostFamilyTwo.name'])
                        ->and($family->email)->toBe($properties_and_values['hostFamilyTwo.email'])
                        ->and($family->phone)->toBe($properties_and_values['hostFamilyTwo.phone'])
                        ->and($family->address)->toBe($properties_and_values['hostFamilyTwo.address']);

    $inbound->refresh();
    $family = $inbound->thirdHostFamily();
    expect($family)->not->toBeNull()
                        ->and($family->name)->toBe($properties_and_values['hostFamilyThree.name'])
                        ->and($family->email)->toBe($properties_and_values['hostFamilyThree.email'])
                        ->and($family->phone)->toBe($properties_and_values['hostFamilyThree.phone'])
                        ->and($family->address)->toBe($properties_and_values['hostFamilyThree.address']);
});

it('displays check for complete passport section', function () {
    $inbound = createInboundRegisteredFor($this->event);
    $inbound->passport()->save(Passport::factory()->make());
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    assertSeesCompletenessIndication($component, 'registration.passport', 'passport.passport_number');
});

it('displays check for complete user section', function () {
    $inbound = createInboundRegisteredFor($this->event);

    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    assertSeesCompletenessIndication($component, 'registration.about-you', 'user.gender');
});

it('displays check for complete rotary section', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $rotary = RotaryInfo::factory()->create();
    $inbound->rotaryInfo()->save($rotary);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    assertSeesCompletenessIndication($component, 'registration.about-rotary', 'rotary.host_district');
});

it('displays check for complete counselor section', function () {
    $inbound = createInboundRegisteredFor($this->event);
    $inbound->counselor()->save(CounselorInfo::factory()->make());
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    assertSeesCompletenessIndication($component, 'registration.about-counselor', 'counselor.name');
});

it('displays check for complete yeo section', function () {
    $inbound = createInboundRegisteredFor($this->event);
    $inbound->yeo()->save(YeoInfo::factory()->make());
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    assertSeesCompletenessIndication($component, 'registration.about-yeo', 'yeo.name');
});

it('displays check for complete bio family section', function () {
    $inbound = createInboundRegisteredFor($this->event);
    $inbound->bioFamily()->save(BioFamily::factory()->make());
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    assertSeesCompletenessIndication($component, 'registration.about-bio-family', 'bioFamily.parent_two');
});

it('displays check for complete host family one section', function () {
    // Arrange
    $inbound = createInboundRegisteredFor($this->event);
    $hostFamily = HostFamily::factory()->first()->create();
    $inbound->hostFamilies()->save($hostFamily);
    actingAs($inbound);

    // Act
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    // Assert
    assertSeesCompletenessIndication($component, 'registration.about-host-family-one', 'hostFamilyOne.email');
});

it('displays check for complete host family two section', function () {
    $inbound = createInboundRegisteredFor($this->event);
    $hostFamily = HostFamily::factory()->nth(2)->create();
    $inbound->hostFamilies()->save($hostFamily);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    assertSeesCompletenessIndication($component, 'registration.about-host-family-two', 'hostFamilyTwo.email');
});

it('displays check for complete host family three section', function () {
    $inbound = createInboundRegisteredFor($this->event);
    $hostFamily = HostFamily::factory()->nth(3)->create();
    $inbound->hostFamilies()->save($hostFamily);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    assertSeesCompletenessIndication($component, 'registration.about-host-family-three', 'hostFamilyThree.email');
});

it('displays check for complete comment section', function () {
    $inbound = createInboundRegisteredFor($this->event);
    $inbound->registrationComment()->save(RegistrationComment::factory()->make());
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);

    assertSeesCompletenessIndication($component, 'registration.comment', 'comment.body');
});

it('displays no checkmark for empty passport on load', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component->assertDontSeeText(__('registration.passport').' ✅');
});

it('displays no checkmark for empty rotary info on load', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component->assertDontSeeText(__('registration.about-rotary').' ✅');
});

it('displays no checkmark for empty counselor info on load', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component->assertDontSeeText(__('registration.about-counselor').' ✅');
});

it('displays no checkmark for empty yeo info on load', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component->assertDontSeeText(__('registration.about-yeo').' ✅');
});

it('displays no checkmark for empty bio family info on load', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component->assertDontSeeText(__('registration.about-bio-family').' ✅');
});

it('displays no checkmark for empty host family one info on load', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component->assertDontSeeText(__('registration.about-host-family-one').' ✅');
});

it('displays no checkmark for empty host family two info on load', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component->assertDontSeeText(__('registration.about-host-family-two').' ✅');
});

it('displays no checkmark for empty host family three info on load', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component->assertDontSeeText(__('registration.about-host-family-three').' ✅');
});

it('displays no checkmark for empty comment on load', function () {
    $inbound = createInboundRegisteredFor($this->event);
    actingAs($inbound);
    $component = Livewire::test(EventRegistration::class, [
        'event' => $this->event,
    ]);
    $component->assertDontSeeText(__('registration.comment').' ✅');
});
/**
 * @param  TestableLivewire  $component
 * @param $headlineKey
 * @param $removingProperty
 * @return void
 */
function assertSeesCompletenessIndication(TestableLivewire $component, $headlineKey, $removingProperty): void
{
    $component->assertSeeText(__($headlineKey).' ✅')
              ->set($removingProperty, '')
              ->assertDontSeeText(__($headlineKey).' ✅')
              ->assertSeeText(__($headlineKey));
}
