<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\TokenAuthMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('login', [AuthController::class, 'loginForm'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'registerForm'])->name('register');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware('admin')
    ->name('dashboard');

//Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
