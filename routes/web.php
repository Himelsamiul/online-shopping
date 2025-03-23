<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CategoryController;

// Backend Routes

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/do/login', [AdminController::class, 'doLogin'])->name('do.login');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/sign/out', [AdminController::class, 'signout'])->name('sign.out');
        Route::get('/dashboard', [AdminController::class, 'home'])->name('dashboard');

        // Category Routes ei khan e
        Route::get('/categories', [CategoryController::class, 'list'])->name('categories.list');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

        // CRUD operations of category
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'delete'])->name('categories.delete');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

        // Unit Routes ei gulaa
        Route::get('/units', [UnitController::class, 'unitlist'])->name('units.list');
        Route::get('units/create', [UnitController::class, 'unitcreate'])->name('units.create');
        Route::post('/units', [UnitController::class, 'unitstore'])->name('units.store');

        // CRUD operations for units
        Route::get('/{unit}/edit', [UnitController::class, 'unitedit'])->name('units.edit');
        Route::put('/{unit}', [UnitController::class, 'unitupdate'])->name('units.update');
        Route::delete('/{unit}', [UnitController::class, 'unitdelete'])->name('units.delete');
        Route::get('/{unit}', [UnitController::class, 'unitshow'])->name('units.show');


        //product er kaj korsi
       // Route::get('products', [ProductController::class, 'list'])->name('products.list');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/list', [ProductController::class, 'list'])->name('products.list');

    });
});
