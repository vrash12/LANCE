<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\WorkScheduleController;
use App\Http\Controllers\PatientRecordController;
use App\Http\Controllers\OpdFormController;

// 1) Redirect “/” to the login screen
Route::get('/', fn() => redirect()->route('login'));

// 2) Authentication (login, register, password reset)
Auth::routes();

// 3) All routes below require the user to be logged in
Route::middleware('auth')->group(function () {

    // 3a) Dashboard / Home
    Route::get('/home', [HomeController::class, 'index'])
         ->name('home');

    // 3b) Admin-only routes
    Route::middleware('role:admin')->group(function () {
        // User management
        Route::resource('users', UserController::class);
        Route::resource('patients', PatientRecordController::class);
        // Queueing page
        Route::get('queue', [QueueController::class, 'index'])
             ->name('queue.index');

             Route::resource('schedules', WorkScheduleController::class);
             Route::resource('opd_forms', App\Http\Controllers\OpdFormController::class);
    });

    // 3c) Encoder-only routes
    Route::middleware('role:encoder')->group(function () {
        // e.g. patient records, data entry…
    });

    // 3d) Patient-only routes
    Route::middleware('role:patient')->group(function () {
        // e.g. OPD form submission…
    });

});
