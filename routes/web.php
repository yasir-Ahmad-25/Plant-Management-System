<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Dashboard Routes
Route::middleware('custom.auth')->controller(DashboardController::class)->group(function() {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('logout', [DashboardController::class, 'logout'])->name('admin.logout');

    // ==================== Categories Section [START] =================
    Route::get('categories', [CategoriesController::class, 'categories'])->name('admin.categories');
    Route::post('storeCategories', [CategoriesController::class, 'storeCategory'])->name('admin.categories.store');
    Route::post('updateCategories', [CategoriesController::class, 'updateCategory'])->name('admin.categories.update');
    Route::post('deleteCategories', [CategoriesController::class, 'deleteCategory'])->name('admin.categories.delete');
    // ==================== Categories Section [END] =================
});


// Authentication Routes
Route::middleware('custom.guest')->controller(AuthenticationController::class)->group(function(){
    Route::get('Login', [AuthenticationController::class, 'login'])->name('auth.login');
    // Post
    Route::post('authenticate', [AuthenticationController::class, 'Authenticate'])->name('auth.authenticate');

});
