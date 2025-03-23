<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Frontend\WebpageController;
use App\Http\Controllers\Frontend\CustomerController;

Route::get('/', [WebpageController::class, 'webpage'])->name('webpage');


// Backend Routes
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/do/login', [AdminController::class, 'doLogin'])->name('do.login');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/sign/out', [AdminController::class, 'signout'])->name('sign.out');
        Route::get('/dashboard', [AdminController::class, 'home'])->name('dashboard');

        // Category Routes
        Route::get('/categories', [CategoryController::class, 'list'])->name('categories.list');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

        // CRUD operations of category
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'delete'])->name('categories.delete');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

        // Unit Routes
        Route::get('/units', [UnitController::class, 'unitlist'])->name('units.list');
        Route::get('units/create', [UnitController::class, 'unitcreate'])->name('units.create');
        Route::post('/units', [UnitController::class, 'unitstore'])->name('units.store');

        // CRUD operations for units
        Route::get('/units/{unit}/edit', [UnitController::class, 'unitedit'])->name('units.edit');
        Route::put('/units/{unit}', [UnitController::class, 'unitupdate'])->name('units.update');
        Route::delete('/units/{unit}', [UnitController::class, 'unitdelete'])->name('units.delete');
        Route::get('/units/{unit}', [UnitController::class, 'unitshow'])->name('units.show');

        // Product Routes
        Route::prefix('/products')->group(function () {
            Route::get('list', [ProductController::class, 'list'])->name('products.list');
            Route::get('create', [ProductController::class, 'create'])->name('products.create');
            Route::post('store', [ProductController::class, 'store'])->name('products.store');

            // CRUD operations for products
            Route::get('{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('{product}', [ProductController::class, 'update'])->name('products.update');
            Route::delete('{product}', [ProductController::class, 'delete'])->name('products.delete');
            Route::get('{product}', [ProductController::class, 'show'])->name('products.show');
        });

    });
});
