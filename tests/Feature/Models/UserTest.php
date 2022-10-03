<?php

use App\Models\Comment;
use App\Models\CounselorInfo;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\HostFamily;
use App\Models\Passport;
use App\Models\Role;
use App\Models\RotaryInfo;
use App\Models\User;
use App\Models\YeoInfo;
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

it('can find document of given category', function () {
    $user = User::factory()
                ->has(Document::factory()->withCategory(DocumentCategory::PassportCopy))
                ->has(Document::factory()->withCategory(DocumentCategory::Unknown))
                ->create();
    expect($user->documentBy(DocumentCategory::PassportCopy))
        ->toBeInstanceOf(Document::class)
        ->category->toBe(DocumentCategory::PassportCopy->value);
});

it('returns null if no matching Document can be found', function () {
    expect(User::factory()->create()->documentBy(DocumentCategory::PassportCopy))
        ->toBeNull();
});

it('returns null if the given category is null', function () {
    expect(User::factory()->create()->documentBy(null))->toBeNull();
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

it('has family name', function () {
    $user = User::factory()->create();
    expect($user->family_name)->toBeString();
});

it('has full name accessor', function () {
    $user = User::factory()->create();
    expect($user->fullName)
        ->toBeString()
        ->toBe($user->first_name.' '.$user->family_name);
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

    $counselor = CounselorInfo::factory()->create();
    $user->counselor()->save($counselor);
    expect($user->counselor)
        ->toBeSameEntityAs($counselor);
});

it('has person info for yeo', function () {
    $user = User::factory()->create();
    expect($user->yeo())
        ->toBeInstanceOf(HasOne::class);

    $yeo = YeoInfo::factory()->create();
    $user->yeo()->save($yeo);
    expect($user->yeo)
        ->toBeSameEntityAs($yeo);
});

it('has different models for yeo and counselor', function () {
    $user = User::factory()->create();
    $counselor = CounselorInfo::factory()->create();
    $yeo = YeoInfo::factory()->create();

    $user->yeo()->save($yeo);
    $user->counselor()->save($counselor);

    expect($user->counselor)
        ->toBeSameEntityAs($counselor)
        ->and($user->yeo)
        ->toBeSameEntityAs($yeo)
        ->and($user->yeo)
        ->not->toBeSameEntityAs($user->counselor);
});

it('has one bio family', function () {
    $user = User::factory()->create();
    expect($user->bioFamily())
        ->toBeInstanceOf(HasOne::class);
});

it('has many host families', function () {
    $user = User::factory()->create();
    expect($user->hostFamilies())
        ->toBeInstanceOf(HasMany::class);
});

it('can access nth host family', function () {
    // Create additional user not used in test explicitly to ensure
    // that the
    User::factory()
        ->has(HostFamily::factory())
        ->create();

    $n = fake()->numberBetween(1, 15);

    $nthHostFamily = HostFamily::factory()->nth($n)->create();
    $user = User::factory()
                ->has(HostFamily::factory()->count(3))
                ->create();
    $user->hostFamilies()->save($nthHostFamily);

    expect($user->hostFamily($n))
        ->toBeSameEntityAs($nthHostFamily);
});

it('can access first host family', function () {
    // Create additional user not used in test explicitly to ensure
    // that the host family is not accidentally the first in the array
    User::factory()
        ->has(HostFamily::factory())
        ->create();

    $n = 1;

    $nthHostFamily = HostFamily::factory()->nth($n)->create();
    $user = User::factory()
                ->has(HostFamily::factory()->count(3))
                ->create();
    $user->hostFamilies()->save($nthHostFamily);

    expect($user->firstHostFamily())
        ->toBeSameEntityAs($nthHostFamily);
});

it('can access second host family', function () {
    User::factory()
        ->has(HostFamily::factory())
        ->create();

    $n = 2;

    $nthHostFamily = HostFamily::factory()->nth($n)->create();
    $user = User::factory()
                ->has(HostFamily::factory()->count(3))
                ->create();
    $user->hostFamilies()->save($nthHostFamily);

    expect($user->secondHostFamily())
        ->toBeSameEntityAs($nthHostFamily);
});

it('can access third host family', function () {
    User::factory()
        ->has(HostFamily::factory())
        ->create();

    $n = 3;

    $nthHostFamily = HostFamily::factory()->nth($n)->create();
    $user = User::factory()
                ->has(HostFamily::factory()->count(3))
                ->create();
    $user->hostFamilies()->save($nthHostFamily);

    expect($user->thirdHostFamily())
        ->toBeSameEntityAs($nthHostFamily);
});

it('makes a new host family if no matching exists', function () {
    $user = User::factory()->create();

    $hostFamily = $user->hostFamily(2);
    expect($hostFamily)
        ->not->toBeNull()
             ->toBeInstanceOf(HostFamily::class)
             ->and($hostFamily->exists())->toBeFalse();
});

it('has registration comment', function () {
    $user = User::factory()->create();

    expect($user->registrationComment())
        ->toBeInstanceOf(HasOne::class);
});

/*
 * Expected: First Name, Last Name, Birthday, Gender, Mobile Phone, Health
 */
it('is complete for expected attributes', function () {
    $user = User::factory()->state([
        'first_name' => fake()->firstName,
        'family_name' => fake()->lastName,
        'birthday' => fake()->date,
        'gender' => fake()->word,
        'mobile_phone' => fake()->phoneNumber,
        'health_issues' => fake()->paragraphs(asText: true),
    ])->make();

    expect($user->isComplete())->toBeTrue();
});

/*
 * Expected: First Name, Last Name, Birthday, Gender, Mobile Phone, Health
 */
it('is NOT complete if one expected attribute is null', function () {
    $requiredAttributes = [
        'first_name' => fake()->firstName,
        'family_name' => fake()->lastName,
        'birthday' => fake()->date,
        'gender' => fake()->word,
        'mobile_phone' => fake()->phoneNumber,
        'health_issues' => fake()->paragraphs(asText: true),
    ];

    foreach (array_keys($requiredAttributes) as $attribute) {
        $user = User::factory()->state($requiredAttributes)
                    ->state([
                        $attribute => null,
                    ])
                    ->make();
        $complete = $user->isComplete();
        expect($complete)->toBeFalse();
    }
});

it('has auto assigned uuid', function () {
    $user = User::factory()->create();
    expect($user->uuid)
        ->toBeString();
});

it('returns info relation for given DocumentCategory', function () {
    $user = User::factory()->create();
    $passportRelation = $user->relationFor(DocumentCategory::PassportCopy);
    expect($passportRelation)
        ->toBeInstanceOf(HasOne::class)
        ->getModel()->toBeInstanceOf(Passport::class)
        ->and($user->relationFor(DocumentCategory::Unknown))
        ->toBeNull();
});
