<?php

use App\Http\Kernel;
use App\Http\Middleware\ApplicationAvailability;
use Maatwebsite\Excel\ExcelServiceProvider;

it('contains service provider for Excel Export', function () {
    expect(config('app.providers'))
        ->toContain(ExcelServiceProvider::class);
});

it('contains middleware for application availability', function () {
    $kernel = resolve(Kernel::class);
    expect($kernel->hasMiddleware(ApplicationAvailability::class))
        ->toBeTrue();
});
