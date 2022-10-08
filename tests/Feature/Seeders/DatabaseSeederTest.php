<?php

namespace Tests;

use App\Models\Event;
use App\Models\Role;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates rotex role', function () {
    $seeder = new DatabaseSeeder();
    $seeder->run();

    expect(Role::where('name', 'rotex')->get()->first())
        ->not->toBeNull()
             ->toBeInstanceOf(Role::class);
});

it('creates no new rotex role if one exists already', function () {
    Role::factory()->rotex()->create();

    $seeder = new DatabaseSeeder();
    $seeder->run();

    expect(Role::where('name', 'rotex')->get()->count())
        ->toBe(1);
});

it('creates participant role', function () {
    $seeder = new DatabaseSeeder();
    $seeder->run();

    expect(Role::where('name', 'participant')->get()->first())
        ->not->toBeNull()
             ->toBeInstanceOf(Role::class);
});

it('creates no new participant role if one exists already', function () {
    Role::factory()->participant()->create();

    $seeder = new DatabaseSeeder();
    $seeder->run();

    expect(Role::where('name', 'participant')->get()->count())
        ->toBe(1);
});

it('creates tour', function () {
    $seeder = new DatabaseSeeder();
    $seeder->run();

    $queryResult = Event::where('name', 'Deutschland Tour');
    expect($queryResult)
        ->count()->toBe(1)
        ->and($queryResult->first())
        ->start->toDateString()->toBe('2023-03-22')
        ->end->toDateString()->toBe('2023-04-08')
             ->hasRole('participant')->toBeTrue();
});

it('creates no tour if it does already exist', function () {
    Event::factory()->state([
        'name' => 'Deutschland Tour',
    ])->create();

    $seeder = new DatabaseSeeder();
    $seeder->run();

    expect(Event::where('name', 'Deutschland Tour')->count())
        ->toBe(1);
});
