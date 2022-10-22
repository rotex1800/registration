<?php

use Maatwebsite\Excel\ExcelServiceProvider;

it('contains service provider for Excel Export', function () {
    expect(config('app.providers'))
        ->toContain(ExcelServiceProvider::class);
});
