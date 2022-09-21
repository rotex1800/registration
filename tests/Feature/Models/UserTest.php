<?php

use App\Models\Comment;
use App\Models\Document;
use App\Models\Passport;
use App\Models\PersonInfo;
use App\Models\Role;
use App\Models\RotaryInfo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

uses(RefreshDatabase::class);

it('has events relation', function () {
    expect((new User())->events())
        ->toBeInstanceOf(BelongsToMany::class);
});

it('can determine if user has registered for event', function () {
    $event = \App\Models\Event::factory()->create();
    $user = User::factory()->create();
    assertFalse($user->hasRegisteredFor($event));
    $user->events()->save($event);
    assertTrue($user->hasRegisteredFor($event));
});

it('belongs to roles', function () {
    $user = User::factory()->create();
    expect($user->roles())
        ->toBeInstanceOf(BelongsToMany::class);
});

it('returns registered-for events', function () {
    $user = User::factory()->create();
    $expected = \App\Models\Event::factory()->count(2)->create();
    $user->events()->saveMany($expected);

    $actual = $user->participatesIn();
    assertEquals(0, $actual->diff($expected)->count());
    assertEquals(0, $expected->diff($actual)->count());
});

it('returns events the user can still register for', function () {
    $role = Role::factory()->create();
    $user = User::factory()->create();
    $user->roles()->attach($role);

    $attends = \App\Models\Event::factory()->create();
    $attends->roles()->attach($role);
    $user->events()->attach($attends);

    $canAttend = \App\Models\Event::factory()->create();
    $canAttend->roles()->attach($role);

    assertFalse($user->canRegisterFor()->contains($attends));
    assertTrue($user->participatesIn()->contains($attends));
});

it('can check if it has a role', function () {
    $user = createUserWithRole('role');
    expect($user->hasRole('role'))
        ->toBeTrue()
        ->and($user->hasRole('other'))
        ->toBeFalse();
});

it('is author of many comments', function () {
    $user = User::factory()
                ->has(Comment::factory()->count(3), 'authoredComments')
                ->create();
    expect($user->authoredComments())
        ->toBeInstanceOf(HasMany::class)
        ->and($user->authoredComments)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(3);
});

it('owns documents', function () {
    $user = User::factory()
                ->has(Document::factory()->count(2))
                ->create();
    expect($user->documents())
        ->toBeInstanceOf(HasMany::class)
        ->and($user->documents)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2);
});

it('can check it owns a document', function () {
    $user = User::factory()
                ->has(Document::factory())
                ->create();

    $document = $user->documents()->first();

    expect($user->owns($document))
        ->toBeTrue();
});

it('can check it does not own a document', function () {
    $user = User::factory()->create();
    $document = Document::factory()->create();

    expect($user->owns($document))
        ->toBeFalse();
});

it('has first name', function () {
    $user = User::factory()->create();
    expect($user->first_name)->toBeString();
});

it('has birthday', function () {
    $user = User::factory()->create();
    expect($user->birthday)
        ->toBeInstanceOf(Carbon::class);
});

it('has gender', function () {
    expect(User::factory()->create()->gender)
        ->toBeString();
});

it('has mobile phone number', function () {
    expect(User::factory()->create()->mobile_phone)
        ->toBeString();
});

it('has health issues text field', function () {
    expect(User::factory()->create()->health_issues)
        ->toBeString();
});

it('has one passport', function () {
    $user = User::factory()
                ->has(Passport::factory())
                ->create();
    expect($user->passport())
        ->toBeInstanceOf(HasOne::class)
        ->and($user->passport)
        ->toBeInstanceOf(Passport::class);
});

test('birthday is cast correctly', function () {
    $user = User::factory()->create();
    expect($user->hasCast('birthday'))
        ->toBeTrue()
        ->and($user->getCasts()['birthday'])->toBe('date:Y-m-d');
});

test('has one rotary info', function () {
    $user = User::factory()->create();
    expect($user->rotaryInfo())
        ->toBeInstanceOf(HasOne::class);

    $info = RotaryInfo::factory()->create();
    $user->rotaryInfo()->save($info);

    $user->refresh();
    expect($user->rotaryInfo)
        ->toBeInstanceOf(RotaryInfo::class)
        ->toBeSameEntityAs($info);
});

it('has person info for counselor', function () {
    $user = User::factory()->create();
    expect($user->counselor())
        ->toBeInstanceOf(HasOne::class);

    $counselor = PersonInfo::factory()->create();
    $user->counselor()->save($counselor);
    expect($user->counselor)
        ->toBeSameEntityAs($counselor);
});

it('has person info for yeo', function () {
    $user = User::factory()->create();
    expect($user->yeo())
        ->toBeInstanceOf(HasOne::class);

    $yeo = PersonInfo::factory()->create();
    $user->yeo()->save($yeo);
    expect($user->yeo)
        ->toBeSameEntityAs($yeo);
});
