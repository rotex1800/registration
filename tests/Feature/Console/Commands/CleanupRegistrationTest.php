<?php

use App\Models\Comment;
use App\Models\CounselorInfo;
use App\Models\Document;
use App\Models\Event;
use App\Models\HostFamily;
use App\Models\Passport;
use App\Models\Role;
use App\Models\RotaryInfo;
use App\Models\User;
use App\Models\YeoInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);
it('cleans up users attending only the select event', function () {
    $eventOne = Event::factory()
        ->has(User::factory()
            ->has(Comment::factory()->count(3), 'authoredComments')
            ->has(Document::factory()->count(7))
            ->has(CounselorInfo::factory(), 'counselor')
            ->has(YeoInfo::factory(), 'yeo')
            ->has(RotaryInfo::factory())
            ->has(Passport::factory())
            ->has(HostFamily::factory()->count(3))
            ->has(Role::factory()->participant()),
            'attendees')
        ->has(User::factory()
            ->has(Role::factory()->rotex()), 'attendees')
        ->create();
    $eventTwo = Event::factory()
        ->create();

    $attendsBothEvents = User::factory()->create();
    $attendsBothEvents->events()->attach($eventOne);
    $attendsBothEvents->events()->attach($eventTwo);

    assertDatabaseCount('users', 3);
    $this->artisan('registration:cleanup-event')
        ->expectsOutputToContain('Which of the following events should be cleaned up?')
        ->expectsOutputToContain("$eventOne->name")
        ->expectsOutputToContain("$eventTwo->name")
        ->expectsQuestion('Id of the event to be cleaned up?', 1);

    assertDatabaseMissing('events', ['id' => 1]);
    assertDatabaseCount('users', 2);
    assertDatabaseCount('comments', 0);
    assertDatabaseCount('bio_families', 0);
    assertDatabaseCount('host_families', 0);
    assertDatabaseCount('documents', 0);
    assertDatabaseCount('yeo_infos', 0);
    assertDatabaseCount('counselor_infos', 0);
    assertDatabaseCount('documents', 0);
    assertDatabaseCount('documents', 0);
    assertDatabaseCount('passports', 0);
    assertDatabaseCount('additional_infos', 0);
    assertDatabaseCount('payments', 0);
});

it('does not fail for unknown event id', function () {
    $eventOne = Event::factory()
        ->create();
    assertDatabaseCount('events', 1);

    $this->artisan('registration:cleanup-event')
        ->expectsOutputToContain('Which of the following events should be cleaned up?')
        ->expectsOutputToContain("$eventOne->name")
        ->expectsQuestion('Id of the event to be cleaned up?', 'q')
        ->expectsOutput("Did not find an event with id 'q'")
        ->assertOk();

    assertDatabaseCount('events', 1);
});

it('Ends early if there are no events', function () {
    $this->artisan('registration:cleanup-event')
        ->expectsOutput("There are no events to clean up. You're all good.")
        ->assertOk();
});
