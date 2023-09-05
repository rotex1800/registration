<?php

namespace Tests;

use App\Http\Middleware\ApplicationAvailability;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use function Pest\Laravel\withoutMiddleware;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        withoutMiddleware(ApplicationAvailability::class);
    }
}
