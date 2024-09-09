<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class ApplicationAvailability
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Config::get('app.availability-middleware.enabled',
            true) || Carbon::now()->isAfter('2023-08-10T00:00:00')) {
            return $next($request);
        } else {
            return redirect('https://rotex1800.de');
        }
    }
}
