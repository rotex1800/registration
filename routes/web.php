<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationsDownloadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('login', [AuthenticationController::class, 'authenticate']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'home'])
        ->name('home')
        ->middleware('auth');

    Route::get('/event/{event}', [EventController::class, 'show'])
        ->name('event.show')
        ->middleware('can:show,event');

    Route::get('/registrations/{event}/download', RegistrationsDownloadController::class)
        ->name('registrations.download');

    Route::get('/registrations/{event}', EventRegistrationsController::class)
        ->name('registrations.show');
});
