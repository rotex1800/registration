<?php

namespace Tests\Http\Middleware;

use App\Http\Middleware\TrustHosts;

it('trusts only the applications domain', function () {
    $middleware = new TrustHosts($this->app);
    expect($middleware->hosts())
        ->toContain(config('app.url'));
});
