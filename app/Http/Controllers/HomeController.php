<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function home()
    {
        $events = Auth::user()?->events()->get();
        return view('home', [
            'events' => $events,
        ]);
    }
}