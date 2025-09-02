<?php

use App\Models\AdditionalInfo;
use App\Models\PersonInfo;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

test('database migration is correct', function () {
    $additionalInfo = AdditionalInfo::factory()->create();
    expect($additionalInfo)->not->toBeNull();
});

it('uses personInfo trait', function () {
    $result = in_array(PersonInfo::class, class_uses_recursive(AdditionalInfo::class));
    expect($result)->toBeTrue();
});

it('has t-shirt size', function () {
    $additionalInfo = AdditionalInfo::factory()->make();
    expect($additionalInfo->tshirt_size)
        ->not->toBeEmpty();
});

it('has allergies column', function () {
    $info = AdditionalInfo::factory()->make();
    expect($info->allergies)
        ->toBeString();
});

it('has diet information', function () {
    $info = AdditionalInfo::factory()->make();
    expect($info->diet)
        ->toBeString();
});

it('has internal note', function () {
    $info = AdditionalInfo::factory()->make();
    expect($info->note)
        ->toBeString();
});

it('has desired group column', function () {
    $info = AdditionalInfo::factory()->make();
    expect($info->desired_group)
        ->toBeString();
});

it('is commentable', function () {
    $info = AdditionalInfo::factory()->make();
    expect($info->comments())
        ->toBeInstanceOf(MorphMany::class);
});

it('can create comment on additional info', function () {
    // Arrange
    $info = AdditionalInfo::factory()->create();
    $content = fake()->words(asText: true);
    $author = User::factory()->create();

    // Act
    $comment = $info->createComment($content, $author->id);

    // Assert
    expect($info->comments()->count())
        ->toBeOne()
        ->and($comment)
        ->not->toBeFalse()
        ->author_id->toBe($author->id)
        ->content->toBe($content);

    assertDatabaseHas('comments', ['commentable_type' => 'App\Models\AdditionalInfo']);
});
