<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Tests\DuskTestCase;

uses(Tests\TestCase::class)->in('Livewire');
uses(Tests\TestCase::class)->in('Feature');
uses(DuskTestCase::class)->in('Browser');
uses()->group('browser')->in('Browser');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

expect()->extend('toBeAllowed', function () {
    return $this
    ->toBeInstanceOf(Response::class)
    ->allowed()->toBeTrue();
});

expect()->extend('toBeDenied', function () {
    return $this
    ->toBeInstanceOf(Response::class)
    ->allowed()->toBeFalse();
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createUserWithRole(string $role): User
{
    return User::factory()
               ->has(Role::factory()->state([
                   'name' => $role,
               ]))
               ->create();
}

function createInboundRegisteredFor(App\Models\Event $event): User
{
    $inbound = createUserWithRole('inbound');
    $inbound->events()->attach($event);

    return $inbound;
}
