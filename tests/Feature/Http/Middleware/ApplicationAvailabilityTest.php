<?php

use App\Http\Middleware\ApplicationAvailability;

it('redirects to rotex page before 10th August 2023', function () {
    $this->travelTo('2023-05-10T12:00:00');
    $request = createRequest('get', '/');
    $response = (new ApplicationAvailability())->handle(
        $request,
        fn() => new \Symfony\Component\HttpFoundation\Response()
    );
    expect($response->isRedirect('https://rotex1800.de'))->toBeTrue();
});

it('handles request starting 10th August 2023', function () {
    $this->travelTo('2023-08-10T00:00:01');
    $request = createRequest('get', '/');
    $response = (new ApplicationAvailability())->handle(
        $request,
        fn() => new \Symfony\Component\HttpFoundation\Response()
    );
    expect($response->isRedirect())->toBeFalse()
                                   ->and($response->getStatusCode())->toBe(200);
});
