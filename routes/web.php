<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\AdminController;

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

        // Bulk delete route
       Route::post('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulkDelete');

    });
});
