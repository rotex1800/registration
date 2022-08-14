<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function home(): View
    {
        $events = Auth::user()?->events()->get();
        return view('home', [
            'events' => $events,
        ]);
    }
}
