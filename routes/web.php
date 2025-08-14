<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

// Dashboard Routes
Route::middleware('custom.auth')->controller(DashboardController::class)->group(function() {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('logout', [DashboardController::class, 'logout'])->name('admin.logout');

    // ==================== Categories Section [START] =================
    Route::get('categories', [CategoriesController::class, 'categories'])->name('admin.categories');
    Route::get('get_category/{id}', [CategoriesController::class, 'get_category'])->name('admin.get_category');
    Route::post('storeCategories', [CategoriesController::class, 'storeCategory'])->name('admin.categories.store');
    Route::post('updateCategories/{id}', [CategoriesController::class, 'updateCategory'])->name('admin.categories.update');
    Route::post('deleteCategories/{id}', [CategoriesController::class, 'deleteCategory'])->name('admin.categories.delete');
    // ==================== Categories Section [END] =================
    
    // ==================== Products Section [START] =================
    Route::get('products', [ProductsController::class, 'index'])->name('admin.products');
    Route::get('get_product/{id}', [ProductsController::class, 'get_product'])->name('admin.get_product');
    Route::post('store_product', [ProductsController::class, 'store_product'])->name('admin.products.store');
    Route::post('update_product/{id}', [ProductsController::class, 'update_product'])->name('admin.products.update');
    Route::post('delete_product/{id}', [ProductsController::class, 'delete_product'])->name('admin.products.delete');
    // ==================== Products Section [END] =================


    // ===================== Sales Section [START] =================
    Route::get('sales', [SalesController::class, 'index'])->name('admin.sales');
    Route::get('get_sale/{id}', [SalesController::class, 'get_sale'])->name('admin.get_sale');
    Route::post('get_product_price', [SalesController::class, 'get_product_price'])->name('admin.sales.product_price');
    Route::get('create_sale_view', [SalesController::class, 'create_sale_view'])->name('admin.sales.create_sale_view');
    Route::post('store_sale', [SalesController::class, 'store_sale'])->name('admin.sales.store');

    Route::get('edit_sale_view/{id}', [SalesController::class, 'edit_sale_view'])->name('admin.sales.edit_sale_view');
    Route::post('update_sale/{id}', [SalesController::class, 'update_sale'])->name('admin.sales.update');

    Route::post('delete_sale/{id}', [SalesController::class, 'delete_sale'])->name('admin.sales.delete');

    Route::get('get_sale_data/{id}', [SalesController::class, 'get_sale_data'])->name('admin.sales.get_sale_data');
    Route::get('view_sale/{id}', [SalesController::class, 'view_sale'])->name('admin.sales.view');
    Route::post('search_sale', [SalesController::class, 'search_sale'])->name('admin.sales.search');
    Route::get('sales_report', [SalesController::class, 'sales_report'])->name('admin.sales.report');
    Route::get('sales_report_pdf', [SalesController::class, 'sales_report_pdf'])->name('admin.sales.report.pdf');
    Route::get('sales_report_excel', [SalesController::class, 'sales_report_excel'])->name('admin.sales.report.excel');
    // ===================== Sales Section [END] =================

    // ===================== Settings Section [START] =================
    Route::get('settings', [DashboardController::class, 'settings'])->name('admin.settings');
    Route::post('update_settings', [DashboardController::class, 'update_settings'])->name('admin.settings.update');
    // ===================== Settings Section [END] =================

    Route::get('sales-overview', [DashboardController::class, 'salesOverview'])->name('dashboard.salesOverview');
});


// Authentication Routes
Route::middleware('custom.guest')->controller(AuthenticationController::class)->group(function(){
    Route::get('Login', [AuthenticationController::class, 'login'])->name('auth.login');
    // Post
    Route::post('authenticate', [AuthenticationController::class, 'Authenticate'])->name('auth.authenticate');

});
