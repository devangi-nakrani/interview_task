<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ShortUrlController::class, 'index'])->name('dashboard');
    Route::post('/invite', [InvitationController::class, 'invite'])->name('invite');
    Route::get('/invite', function() { return redirect()->route('dashboard'); });
    Route::post('/shorten', [ShortUrlController::class, 'store'])->name('shorten');
    Route::get('/shorten', function() { return redirect()->route('dashboard'); });
});

// Publicly resolvable route
Route::get('/s/{code}', [ShortUrlController::class, 'resolve'])->name('short_url.resolve');
