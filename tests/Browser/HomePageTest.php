<?php

namespace Tests\Feature;

use App\Livewire\FileDownload;
use App\Models\Event;
use App\Models\Role;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('shows main navigation', function () {
    $user = User::factory()->create();
    actingAs($user)
        ->get('/home')
        ->assertSeeLivewire('main-navigation');
});

it('shows events the user attends', function () {
    $user = User::factory()
        ->has(Event::factory()->count(2))
        ->create();

    actingAs($user)
        ->get('/home')
        ->assertSee('Meine Events')
        ->assertSeeLivewire('event-summary');
});

it('does not show my events section if the user does not attend any events', function () {
    $user = User::factory()->create();
    actingAs($user)
        ->get('/home')
        ->assertDontSee('Meine Events')
        ->assertDontSeeLivewire('event-summary');
});

it('shows events the user can attend', function () {
    $role = Role::factory()->create();

    $user = User::factory()
        ->create();
    $user->roles()->attach($role);
    $user->save();

    $event = Event::factory()
        ->create();
    $event->roles()->attach($role);
    $event->save();

    actingAs($user)
        ->get('/home')
        ->assertSee('Verfügbare Events');
});

it('does not show events the user is attending in further events', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();
    $user->events()->attach($event);
    actingAs($user)
        ->get('/home')
        ->assertSeeLivewire('event-summary')
        ->assertDontSee('Verfügbare Events')
        ->assertSee($event->name);
});

it('does not show events the user can not attend', function () {
    $oneRole = Role::factory(['name' => 'role'])->make();
    $user = User::factory()->create();
    $user->roles()->save($oneRole);

    $otherRole = Role::factory(['name' => 'other'])->make();
    $event = Event::factory()->create();
    $event->roles()->save($otherRole);

    actingAs($user)
        ->get('/home')
        ->assertDontSee('Verfügbare Events');
});

it('shows overview of registrations', function () {
    $user = createUserWithRole('rotex');

    $eventOne = Event::factory()->create();
    $eventTwo = Event::factory()->create();

    $this->actingAs($user)
        ->get('/home')
        ->assertStatus(200)
        ->assertSeeTextInOrder([
            'Anmeldungen',
            $eventOne->name,
            $eventTwo->name,
        ]);
});

it('shows download section', function () {
    $user = User::factory()->create();
    $this->actingAs($user)
        ->get(route('home'))
        ->assertStatus(200)
        ->assertSee(__('Available downloads'))
        ->assertSeeLivewire(FileDownload::class);
});

it('shows overview of registrations for non-rotex role', function () {
    $user = createUserWithRole('participant');

    $eventOne = Event::factory()->create();
    $eventTwo = Event::factory()->create();

    $this->actingAs($user)
        ->get('/home')
        ->assertStatus(200)
        ->assertDontSeeText([
            'Anmeldungen',
            $eventOne->name,
            $eventTwo->name,
        ]);
});

it('shows explanation if no events exist at the moment', function () {
    $user = createUserWithRole('rotex');

    $this->actingAs($user)
        ->get('/home')
        ->assertStatus(200)
        ->assertSeeTextInOrder([
            'Anmeldungen',
            'Derzeit gibt es keine offenen Anmeldungen',
        ]);
});

it('requires email to be verfied', function () {
    $user = User::factory()->state(['email_verified_at' => null])->create();
    $this->actingAs($user)
        ->get('/home')
        ->assertRedirect(route('verification.notice'));
});

it('can access verification notice without verified email', function () {
    $user = User::factory()->state(['email_verified_at' => null])->create();
    $this->actingAs($user)
        ->get(route('verification.notice'))
        ->assertStatus(200);
});
