<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Dashboard Routes
Route::middleware('custom.auth')->controller(DashboardController::class)->group(function() {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('logout', [DashboardController::class, 'logout'])->name('admin.logout');
});


// Authentication Routes
Route::middleware('custom.guest')->controller(AuthenticationController::class)->group(function(){
    Route::get('Login', [AuthenticationController::class, 'login'])->name('auth.login');
    // Post
    Route::post('authenticate', [AuthenticationController::class, 'Authenticate'])->name('auth.authenticate');

});
