<?php

namespace Tests\Http\Middleware;

use App\Http\Middleware\TrimStrings;

it('trims inputs', function () {
    $request = createRequest('get', '/');
    $request->replace([
        'key' => '            value            ',
    ]);

    (new TrimStrings())->handle(
        $request,
        function ($req) {
            expect($req->input('key'))->toBe('value');
        }
    );
});

it('does not trim password', function () {
    $request = createRequest('get', '/');
    $request->replace([
        'password' => ' value',
    ]);

    (new TrimStrings())->handle(
        $request,
        function ($req) {
            expect($req->input('password'))->toBe(' value');
        }
    );
});

it('does not trim password_confirmation', function () {
    $request = createRequest('get', '/');
    $request->replace([
        'password_confirmation' => ' value',
    ]);

    (new TrimStrings())->handle(
        $request,
        function ($req) {
            expect($req->input('password_confirmation'))->toBe(' value');
        }
    );
});

it('does not trim current_password', function () {
    $request = createRequest('get', '/');
    $request->replace([
        'current_password' => ' value',
    ]);

    (new TrimStrings())->handle(
        $request,
        function ($req) {
            expect($req->input('current_password'))->toBe(' value');
        }
    );
});

it('expects all these inputs', function () {
    class TestTrimStrings extends TrimStrings
    {
        public function test()
        {
            expect($this->except)
                ->toHaveCount(3)
                ->toContain(
                    'current_password',
                    'password',
                    'password_confirmation'
                );
        }
    }

    $cut = new TestTrimStrings();
    $cut->test();
});
