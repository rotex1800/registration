<?php

use App\Models\AdditionalInfo;
use App\Models\BioFamily;
use App\Models\Comment;
use App\Models\CounselorInfo;
use App\Models\Document;
use App\Models\Event;
use App\Models\HostFamily;
use App\Models\Passport;
use App\Models\Payment;
use App\Models\Role;
use App\Models\RotaryInfo;
use App\Models\User;
use App\Models\YeoInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);

it('lists events and their ids', function () {
    $eventOne = Event::factory()
        ->has(User::factory()
            ->has(Comment::factory()->count(3), 'authoredComments')
            ->has(Document::factory()->count(7))
            ->has(CounselorInfo::factory(), 'counselor')
            ->has(YeoInfo::factory(), 'yeo')
            ->has(RotaryInfo::factory())
            ->has(Passport::factory())
            ->has(Role::factory()->participant()), 'attendees')
        ->has(User::factory()
            ->has(Role::factory()->rotex())
            ->has(BioFamily::factory())
            ->has(AdditionalInfo::factory())
            ->has(Payment::factory()->count(2))
            ->has(HostFamily::factory()->count(3)), 'attendees')
        ->create();
    $eventTwo = Event::factory()
        ->create();

    $attendsBothEvents = User::factory()->create();
    $attendsBothEvents->events()->attach($eventOne);
    $attendsBothEvents->events()->attach($eventTwo);

    assertDatabaseCount('users', 3);
    assertDatabaseCount('users', 3);
    $this->artisan('registration:cleanup-event')
        ->expectsOutputToContain('Which of the following events should be cleaned up?')
        ->expectsOutputToContain("$eventOne->name")
        ->expectsOutputToContain("$eventTwo->name")
        ->expectsQuestion('Id of the event to be cleaned up?', 1);

    assertDatabaseMissing('events', ['id' => 1]);
    assertDatabaseCount('users', 1);
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

it('Ends early if there are no events', function () {
    $this->artisan('registration:cleanup-event')
        ->expectsOutput("There are no events to clean up. You're all good.")
        ->assertOk();
});
